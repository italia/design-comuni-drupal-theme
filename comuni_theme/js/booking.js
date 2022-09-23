function appointment() {

  /* Steps Page - Next and Back button */

  var content = document.querySelector(".section-wrapper");
  var currentStep = 1;
  var navscroll = document.querySelector(
    '[data-index="'.concat(currentStep, '"]')
  );
  var progressBar = document.querySelector(
    '[data-progress="'.concat(currentStep, '"]')
  );
  // need to define btns globally
  var btnNext = content.querySelector(".btn-next-step");
  var btnBack = content.querySelector(".btn-back-step");

  function pageSteps() {
    if (!content) return;
    var btnSave = content.querySelectorAll(".saveBtn");
    navscroll.classList.add("d-lg-block");
    progressBar.classList.remove("d-none");
    btnSave.forEach(function (element) {
      element.classList.add("invisible");
    });

    if (btnNext) {
      btnNext.addEventListener("click", function () {
        openNext();
      });
    }

    if (btnBack) {
      btnBack.addEventListener("click", function () {
        backPrevious();
      });
    }
  }

  function openNext() {
    btnBack.disabled = false;
    var btnSave = content.querySelectorAll(".saveBtn");
    var steps = content.querySelectorAll("[data-steps]");
    var nextStep = content.querySelector(
      '[data-steps="'.concat(currentStep + 1, '"]')
    );
    var stepWrapper = content.querySelector("[data-steps].active");
    navscroll.classList.remove("d-lg-block");
    progressBar.classList.remove("d-block");
    progressBar.classList.add("d-none");

    if (currentStep == steps.length) {
      confirmAppointment();
      return;
    } else {
      stepWrapper.classList.add("d-none");
      stepWrapper.classList.remove("active");
      nextStep.classList.add("active");
      nextStep.classList.remove("d-none");
      document.getElementById("form-steps")
        .scrollIntoView({ behavior: "smooth" });
      currentStep = currentStep + 1;
      checkMandatoryFields();
      progressBar = document.querySelector(
        '[data-progress="'.concat(currentStep, '"]')
      );
      progressBar.classList.add("d-block");
      progressBar.classList.remove("d-none");

      if (currentStep < steps.length) {
        navscroll = document.querySelector(
          '[data-index="'.concat(currentStep, '"]')
        );
        navscroll.classList.add("d-lg-block");
      }

      if (currentStep == steps.length) {
        content.classList.remove("offset-lg-1");
      }

      if (currentStep == steps.length) {
        btnNext.disabled = false;
        content.querySelector(".steppers-btn-confirm span").innerHTML = "Invia";
        btnSave.forEach(function (element) {
          element.classList.remove("invisible");
          element.classList.add("visible");
          setReviews();
        });
      }
    }
  }

  function backPrevious() {
    btnNext.disabled = false;
    var btnSave = content.querySelectorAll(".saveBtn");
    var steps = content.querySelectorAll("[data-steps]");
    var stepWrapper = content.querySelector("[data-steps].active");
    var previousStep = content.querySelector(
      '[data-steps="'.concat(currentStep - 1, '"]')
    );

    if (currentStep == 1) {
      return;
    } else {
      previousStep.classList.remove("d-none");
      previousStep.classList.add("active");
      stepWrapper.classList.add("d-none");
      stepWrapper.classList.remove("active");
      navscroll.classList.remove("d-lg-block");
      progressBar.classList.add("d-none");
      currentStep = currentStep - 1;
      progressBar = document.querySelector(
        '[data-progress="'.concat(currentStep, '"]')
      );
      progressBar.classList.toggle("d-none");
      content.querySelector(".steppers-btn-confirm span").innerHTML = "Avanti";

      if (currentStep < steps.length) {
        navscroll = document.querySelector(
          '[data-index="'.concat(currentStep, '"]')
        );
        navscroll.classList.add("d-lg-block");
        content.classList.add("offset-lg-1");
      }

      if (currentStep < steps.length) {
        btnSave.forEach(function (element) {
          element.classList.remove("visible");
          element.classList.add("invisible");
        });
      }

      if (currentStep == 1) {
        btnBack.disabled = true;
      }
    }
  }

  pageSteps();

  /* Define an empty object to collect answers */
  const answers = {};

  const saveAnswerByValue = (key, value, toBeDecoded = false) => {
    if (toBeDecoded) {
      const decodedvalue = decodeURIComponent(value);
      const newValue = JSON.parse(decodedvalue);
      answers[key] = newValue;
    } else answers[key] = value;
    if (key == "office") answers.place = null;
    checkMandatoryFields();
  };
  const saveAnswerById = (key, id, callback) => {
    const value = document.getElementById(id)?.value;
    answers[key] = JSON.parse(value);
    if (typeof callback == "function") callback();
    checkMandatoryFields();
  };

  /* Get Luoghi by Unità organizzativa - Step 1 */
  const officeSelect = document.getElementById("office-choice");
  officeSelect.addEventListener("change", () => {
    saveAnswerByValue("office", officeSelect?.value);

    if (officeSelect?.value) {
      const uriSegment = encodeURI(officeSelect.value);
      fetch(`/api/v1/ufficio/${uriSegment}/sedi`)
        .then((response) => response.json())
        .then(({ data }) => {
          document.querySelector("#place-cards-wrapper").innerHTML = "";
          const { sede_principale, altre_sedi } = data[0]
          const places = sede_principale.concat(altre_sedi)
          for (const place of places) {
            const reducedPlace = {
              nome: place.title,
              indirizzo: place.indirizzo,
              apertura: place.orario_apertura,
              id: place.id,
            };
            const placeCardsWrapper = document.querySelector("#place-cards-wrapper")
            placeCardsWrapper.innerHTML += `
            <div class="cmp-info-radio radio-card">
              <div class="card p-3 p-lg-4">
                <div class="card-header mb-0 p-0">
                  <div class="form-check m-0">
                    <input
                      class="radio-input"
                      name="beneficiaries"
                      type="radio"
                      id=${place?.id}
                      value='${JSON.stringify(reducedPlace)}'
                    />
                    <label for=${place?.id}>
                    <h3 class="big-title">
                      ${place?.title}
                    </h3></label
                    >
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="info-wrapper">
                    <span corario_aperturalass="info-wrapper__label">Sportello</span>
                    <p class="info-wrapper__value">CIE</p>
                  </div>
                  <div class="info-wrapper">
                    <span class="info-wrapper__label">Indirizzo</span>
                    <p class="info-wrapper__value">
                      ${place?.indirizzo}
                    </p>
                  </div>
                  <div class="info-wrapper info-orari">
                    <span class="info-wrapper__label">Apertura</span>
                    <div class="info-wrapper__value">
                      ${!place?.orario_apertura ? 'non disponibile' : place.orario_apertura}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            `;
            const placeCardsInputs = placeCardsWrapper.getElementsByTagName('input')
            for (input of placeCardsInputs) {
              input.onclick = () => saveAnswerById('place', place?.id, () => setSelectedPlace())
            }
          }
        })
        .catch((err) => {
          console.error("err", err);
        });

      /* Get Servizi by Unità organizzativa - Step 3 */
      fetch(`/api/v1/servizi/canale/${uriSegment}`)
        .then((response) => response.json())
        .then((data) => {
          document.querySelector("#motivo-appuntamento").innerHTML =
            '<option selected="selected" value="">Seleziona opzione</option>';
          for (const service of data) {
            document.querySelector("#motivo-appuntamento").innerHTML += `
            <option value="${service?.title}">${service?.title}</option>
            `;
          }
        })
        .catch((err) => {
          console.error("err", err);
        });
    } else {
      document.querySelector("#place-cards-wrapper").innerHTML = "";
    }
  });

  /* Step 2 */
  /* Get appointments calendar */
  const appointment = document.getElementById("appointment");
  appointment.addEventListener("change", () => {
    answers.appointment = null;
    checkMandatoryFields();
    // fetch(`a[i/v1/appuntamenti/${appointment?.value}/{answers?.place?.id}`)
    fetch('/modules/custom/design-comuni-drupal-theme/comuni_theme/assets/mocks/appuntamenti.json')
      .then((response) => {
        if (!response.ok) {
          throw new Error("HTTP error " + response.status);
        }
        return response.json();
      })
      .then((data) => {
        const radioAppointment = document.querySelector("#radio-appointment")
        radioAppointment.innerHTML = "";
        for (const dates of data) {
          const { startDate, endDate } = dates;
          const startDay = startDate.split("T")[0];
          const startDayStr = new Date(startDay).toLocaleString('it-IT', {
            weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric",
          });
          const id = startDate + "/" + endDate;
          const value = encodeURIComponent(
            JSON.stringify({ startDate, endDate })
          );

          radioAppointment.innerHTML += `
          <div class="radio-body border-bottom border-light">
          <input name="radio" type="radio" id="${id}" />
          <label for="${id}" class="text-capitalize">${startDayStr} ore ${startDate.split("T")[1]
            }</label>
          </div>
          `;

          const radioAppointmentInputs = radioAppointment.getElementsByTagName('input')
          for (input of radioAppointmentInputs) {
            input.onclick = () => saveAnswerByValue('appointment', value, true)
          }
        }
      })
      .catch((err) => {
        console.error("err", err);
      });
  });

  /* Get selected office */
  const setSelectedPlace = () => {
    const place = answers?.place;
    document.querySelector("#selected-place-card").innerHTML = `
    <div class="cmp-info-summary bg-white mb-4 mb-lg-30 p-4">
    <div class="card">
        <div
        class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end"
        >
        <h3 class="title-large-semi-bold mb-3">
          ${place?.nome}
        </h3>
        </div>

        <div class="card-body p-0">
        <div class="single-line-info border-light">
            <div class="text-paragraph-small">Sportello</div>
            <div class="border-light">
            <p class="data-text">CIE</p>
            </div>
        </div>
        <div class="single-line-info border-light">
            <div class="text-paragraph-small">Indirizzo</div>
            <div class="border-light">
            <p class="data-text">
              ${place?.indirizzo}
            </p>
            </div>
        </div>
        <div class="single-line-info border-light">
            <div class="text-paragraph-small">Apertura</div>
            <div class="border-light">
            <div class="data-text">
              ${!place?.apertura ? 'non disponibile' : place.apertura}
            </div>
            </div>
        </div>
        </div>
        <div class="card-footer p-0"></div>
    </div>
    </div>
  </div>
    `;
  };

  /* Step 3 */
  const serviceSelect = document.getElementById("motivo-appuntamento");
  serviceSelect.addEventListener("change", () => {
    saveAnswerByValue("service", serviceSelect?.value);
  });

  const moreDetailsText = document.getElementById("form-details");
  moreDetailsText.addEventListener("input", () => {
    saveAnswerByValue("moreDetails", moreDetailsText?.value);
  });

  /* Step 4 */
  const nameInput = document.getElementById("name");
  nameInput.addEventListener("input", () => {
    saveAnswerByValue("name", nameInput?.value);
  });

  const surnameInput = document.getElementById("surname");
  surnameInput.addEventListener("input", () => {
    saveAnswerByValue("surname", surnameInput?.value);
  });

  const emailInput = document.getElementById("email");
  emailInput.addEventListener("input", () => {
    saveAnswerByValue("email", emailInput?.value);
  });

  const getDay = () => {
    const day = answers?.appointment?.startDate?.split("T")[0];
    return new Date(day).toLocaleString('it-IT', {
      weekday: "long",
      day: "2-digit",
      month: "long",
      year: "numeric",
    });
  };
  const getHour = () => {
    const dates = answers?.appointment;
    return [dates?.startDate?.split("T")[1], dates?.endDate?.split("T")[1]];
  };
  /* Step 5 */

  const setReviews = () => {
    const dates = answers?.appointment;
    const day = dates?.startDate?.split("T")[0];
    const formatDay = new Date(day).toLocaleString('it-IT', {
      weekday: "long",
      day: "2-digit",
      month: "long",
      year: "numeric",
    });
    const hour =
      dates?.startDate?.split("T")[1] + " - " + dates?.endDate?.split("T")[1];

    //set all values
    document.getElementById("review-office").innerText = answers?.office;
    document.getElementById("review-place").innerText = answers?.place?.nome;
    document.getElementById("review-date").innerText = getDay();
    document.getElementById("review-hour").innerText = `${getHour()[0]} - ${
      getHour()[1]
    }`;
    document.getElementById("review-date").innerText = formatDay;
    document.getElementById("review-hour").innerText = hour;
    document.getElementById("review-service").innerText = answers?.service;
    document.getElementById("review-details").innerText = answers?.moreDetails;
    document.getElementById("review-name").innerText = answers?.name;
    document.getElementById("review-surname").innerText = answers?.surname;
    document.getElementById("review-email").innerText = answers?.email;
  };

  /* Check mandatory fields */
  const checkMandatoryFields = () => {
    switch (currentStep) {
      case 1:
        if (answers?.office && answers?.place) btnNext.disabled = false;
        else btnNext.disabled = true;
        break;

      case 2:
        if (answers?.appointment) btnNext.disabled = false;
        else btnNext.disabled = true;
        break;

      case 3:
        if (answers?.service && answers?.moreDetails) btnNext.disabled = false;
        else btnNext.disabled = true;
        break;

      case 4:
        if (answers?.name && answers?.surname && answers?.email)
          btnNext.disabled = false;
        else btnNext.disabled = true;
        break;

      default:
        break;
    }
  };

  async function getCsrfTokenRating() {
    try {
      const sessionToken = await fetch('session/token');
      const csrfToken = await sessionToken.text();
      return csrfToken;
    } catch(e) {
      console.error(e);
    }
  }

  function successFeedback() {
    document.getElementById("form-steps").classList.add("d-none");
    document.getElementById("email-recap").innerText = answers?.email;
    document.getElementById("date-recap").innerText = `
      ${getDay()} dalle ore ${getHour()[0]} alle ore ${getHour()[1]}
    `;
    document.querySelector(".cmp-hero").classList.add("d-none");
    const finalStep = document.getElementById("final-step");
    const addressBox = finalStep.querySelector(".address-wrapper");
    addressBox.querySelector(".title-small").innerHtml = `
    <a href="#"
      aria-label="Vai a ${answers?.place?.nome}"
      title="Vai a ${answers?.place?.nome}"
      class="" data-focus-mouse="false"
    >${answers?.place?.nome}</a>
    `;
    addressBox.querySelector(".subtitle-small").innerText = answers?.place?.indirizzo;
    finalStep.classList.remove("d-none");
    finalStep.scrollIntoView({ behavior: "smooth" })

    fetch(`/api/v1/servizio/dettaglio/${answers.service}`)
    .then((response) => response.json())
    .then((data) => {
      const cosaServe = data[0].cosa_serve;
      document.getElementById("needed").innerHtml = `${cosaServe}`;
    })
    .catch(err => console.error(err));
  }

  /* confirm appointment - Submit */
  const confirmAppointment = () => {
    getCsrfTokenRating()
      .then(csrfToken => {
        fetch('/api/v1/create/appuntamento', {
          method: "POST",
          body: JSON.stringify(answers),
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken
          },
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("HTTP error " + response.status);
            }
            successFeedback();
            // return response.json();
          })
          // .then((data) => {
          // })
          .catch((err) => {
            console.error("err", err);
          });
      });
  };
};

(function() {
  if (!document.getElementById("form-steps")) return
  appointment()
})()
