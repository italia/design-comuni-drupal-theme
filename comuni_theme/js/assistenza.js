(function() {

  const $wrapper = document.querySelector('.container-assistenza')

  /* the API returns an array with the services names or an empty array, but eventual errors aren't blocking */
  async function getServices(categoria) {
    try {
      const res = await fetch(`./api/v1/servizi${!!categoria ? `/${categoria}` : ''}`)
      const servizi = await res.json()
      return servizi
    } catch(e) {
      console.error(e)
    }
  }

  async function getCsrfTokenRating() {
    try {
      const sessionToken = await fetch('session/token')
      const csrfToken = await sessionToken.text()
      return csrfToken
    } catch(e) {
      console.error(e)
    }
  }

  async function postNode(n) {

    /* select form inputs */
    try {
      const nome = $wrapper.querySelector('[name="name"]').value;
      const cognome = $wrapper.querySelector('[name="surname"]').value;
      const email = $wrapper.querySelector('[name="email"]').value;
      const categoria = $wrapper.querySelector('#category').value;
      const servizio = $wrapper.querySelector('#service').value;
      const descrizione = $wrapper.querySelector('#description').value;

      const node = {
        title: `ticket_${new Date().toISOString()}`,
        nome,
        cognome,
        email,
        categoria,
        servizio,
        descrizione
      }

      /* input validation */
      for (entry of Object.values(node)) {
        if (!entry) return { success: false, error: 'non sono ammessi campi vuoti' }
      }

      /* csrf token validation */
      const csrfToken = await getCsrfTokenRating()
      if (!csrfToken) return  { success: false, error: 'no csrf token' }

      /* node creation request */
      const url = './api/v1/create/ticket'

      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': csrfToken
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(node)
      });

      if (res.ok) {
        return { success: true, error: null }
      } else {
        const msg = await res.json()
        return { success: false, error: msg }
      }
    } catch(e) {
      console.error(e)
    }
  }

  function resetServizio(select_servizio) {
    const firstSelectChild = select_servizio.firstElementChild
    select_servizio.innerHTML = ''
    select_servizio.append(firstSelectChild)
    select_servizio.disabled = true
  }

  function successFeedback() {
    document.getElementById('first-step').classList.add('d-none');
    document.getElementById('email-recap').innerText = $wrapper.querySelector('[name="email"]').value;
    document.querySelector(".cmp-hero").classList.add("d-none");
    document.getElementById('second-step').classList.remove('d-none');
  }

  function createFailureFeedback(error) {
    if (error === 'non sono ammessi campi vuoti') return
    const feedbackDetails = document.createElement('p')
    feedbackDetails.classList.add('form-feedback', 'just-validate-error-label', 'ms-0')
    feedbackDetails.innerText = 'something went wrong, try again'
    const feedback = document.createElement('div')
    feedback.classList.add('errorFeedback')
    feedback.appendChild(feedbackDetails)
    return feedback
  }

  async function assistenza() {
    const form = $wrapper.querySelector('.steppers-content')
    if (!form) return

    const select_category = form.querySelector('#category')
    if (!select_category) return

    const select_servizio = form.querySelector('#service')
    if (!select_servizio) return

    select_category.addEventListener('change', async (event) => {

      resetServizio(select_servizio)

      const categoria = event.target.value
      if (!categoria) return

      const servizi = await getServices(categoria)
      if (!Array.isArray(servizi)) return

      for (servizio of servizi) {
        const option = document.createElement('option')
        option.value = servizio.title
        option.text = servizio.title
        select_servizio.add(option)
      }

      if (select_servizio.childElementCount > 1) select_servizio.disabled = false
    })

    form.addEventListener('submit', async () => {
      /* clear error message */
      const errorFeedback = form.querySelector('.errorFeedback')
      if (errorFeedback) errorFeedback.remove()
      /* API call */
      const result = await postNode()
      if (result.success) {
        /* show success message */
        successFeedback()
        /* scroll to top of page */
        const navbar = document.querySelector('.menu-wrapper')
        if (navbar) navbar.scrollIntoView({ behavior: 'smooth' })
      } else {
        /* append failure message */
        const failureFeedback = createFailureFeedback(result.error)
        if (!failureFeedback) return
        const privacyWrapper = form.querySelector('.privacy-wrapper')
        if (!privacyWrapper) return
        form.insertBefore(failureFeedback, privacyWrapper)
      }
    })
  }

  if ($wrapper) assistenza()

})()
