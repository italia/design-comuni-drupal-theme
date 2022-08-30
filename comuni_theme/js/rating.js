(function() {
    document.addEventListener('feedback-submit', function (){

      var inputRating = document.querySelectorAll('[name="ratingA"]');

      var stars;
      for (var i = 0; i < inputRating.length; i++) {
        if (inputRating[i].checked) {
           stars = 5 - i
        }
      }

      function getCsrfTokenRating(callback) {
        const sessionToken =  fetch('session/token')
          .then((response) => {
            return response.text()
          });
        const getToken = async () => {
          const csrfToken = await sessionToken;
          callback(csrfToken);
        };
        getToken();
      }

      function postNode(csrfToken) {
        const radioButtons = stars > 3
          ? document.querySelectorAll('input[name="rating1"]')
          : document.querySelectorAll('input[name="rating2"]');
        let selectedRadio;
        for (const radioButton of radioButtons) {
          if (radioButton.checked) {
            selectedRadio = radioButton.nextElementSibling.innerHTML;
            break;
          }
        }
        const urlPieces = [location.protocol, "//", location.host, location.pathname];
        const page = urlPieces.join("");
        var node = {
          "title": document.title,
          "star": stars,
          "radioResponse": selectedRadio,
          "freeText": document.querySelector('#formGroupExampleInputWithHelp').value,
          "page": page
        }

        async function postData(url = '', data = {}) {
          // Default options are marked with *
          const response = await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-Token': csrfToken
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(node)
          });
          return response.json();
        }

        postData('./api/v1/create/valutazione')
          .then(data => {
            document.getElementById('rating-feedback').innerHTML = "Grazie, il tuo parere ci aiuterà a migliorare il servizio!";
          }).catch(err => {
          document.getElementById('rating-feedback').innerHTML = "Ops, si è verificato un errore.";
        });

      }

      function sendRating(){
        getCsrfTokenRating(function (csrfToken) {
          postNode(csrfToken);
        });
      }

      sendRating();

    } , false);
})();




