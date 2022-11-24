var content=document.querySelector(".section-wrapper"),currentStep=1,navscroll=document.querySelector('[data-index="'.concat(currentStep,'"]')),progressBar=document.querySelector('[data-progress="'.concat(currentStep,'"]')),btnNext=content.querySelector(".btn-next-step"),btnBack=content.querySelector(".btn-back-step");function pageSteps(){var e;content&&(e=content.querySelectorAll(".saveBtn"),navscroll.classList.add("d-lg-block"),progressBar.classList.remove("d-none"),e.forEach(function(e){e.classList.add("invisible")}),btnNext&&btnNext.addEventListener("click",function(){openNext()}),btnBack)&&btnBack.addEventListener("click",function(){backPrevious()})}function openNext(){btnBack.disabled=!1;var e=content.querySelectorAll(".saveBtn"),t=content.querySelectorAll("[data-steps]"),n=content.querySelector('[data-steps="'.concat(currentStep+1,'"]')),a=content.querySelector("[data-steps].active");navscroll.classList.remove("d-lg-block"),progressBar.classList.remove("d-block"),progressBar.classList.add("d-none"),currentStep==t.length?confirmAppointment():(a.classList.add("d-none"),a.classList.remove("active"),n.classList.add("active"),n.classList.remove("d-none"),currentStep+=1,checkMandatoryFields(),(progressBar=document.querySelector('[data-progress="'.concat(currentStep,'"]'))).classList.add("d-block"),progressBar.classList.remove("d-none"),currentStep<t.length&&(navscroll=document.querySelector('[data-index="'.concat(currentStep,'"]'))).classList.add("d-lg-block"),currentStep==t.length&&content.classList.remove("offset-lg-1"),currentStep==t.length&&(btnNext.disabled=!1,content.querySelector(".steppers-btn-confirm span").innerHTML="Invia",e.forEach(function(e){e.classList.remove("invisible"),e.classList.add("visible"),setReviews()})))}function backPrevious(){btnNext.disabled=!1;var e=content.querySelectorAll(".saveBtn"),t=content.querySelectorAll("[data-steps]"),n=content.querySelector("[data-steps].active"),a=content.querySelector('[data-steps="'.concat(currentStep-1,'"]'));1!=currentStep&&(a.classList.remove("d-none"),a.classList.add("active"),n.classList.add("d-none"),n.classList.remove("active"),navscroll.classList.remove("d-lg-block"),progressBar.classList.add("d-none"),--currentStep,(progressBar=document.querySelector('[data-progress="'.concat(currentStep,'"]'))).classList.toggle("d-none"),content.querySelector(".steppers-btn-confirm span").innerHTML="Avanti",currentStep<t.length&&((navscroll=document.querySelector('[data-index="'.concat(currentStep,'"]'))).classList.add("d-lg-block"),content.classList.add("offset-lg-1")),currentStep<t.length&&e.forEach(function(e){e.classList.remove("visible"),e.classList.add("invisible")}),1==currentStep)&&(btnBack.disabled=!0)}pageSteps();const answers={},saveAnswerByValue=(e,t,n=!1)=>{n?(n=decodeURIComponent(t),n=JSON.parse(n),answers[e]=n):answers[e]=t,"office"==e&&(answers.place=null),checkMandatoryFields()},saveAnswerById=(e,t,n)=>{t=document.getElementById(t)?.value,answers[e]=JSON.parse(t),"function"==typeof n&&n(),checkMandatoryFields()},officeSelect=document.getElementById("office-choice"),appointment=(officeSelect.addEventListener("change",()=>{var e;saveAnswerByValue("office",officeSelect?.value),officeSelect?.value?(e=new URLSearchParams({title:officeSelect.value}),fetch("/wp-json/wp/v2/sedi/ufficio/?"+e).then(e=>e.json()).then(e=>{document.querySelector("#place-cards-wrapper").innerHTML="";for(const n of e){var t={nome:n.post_title,indirizzo:n.indirizzo,apertura:n.apertura,id:n.identificativo};document.querySelector("#place-cards-wrapper").innerHTML+=`
          <div class="cmp-info-radio radio-card">
            <div class="card p-3 p-lg-4">
              <div class="card-header mb-0 p-0">
                <div class="form-check m-0">
                    <input
                    class="radio-input"
                    name="beneficiaries"
                    type="radio"
                    id=${n?.ID}
                    value='${JSON.stringify(t)}'
                    onclick="saveAnswerById('place', ${n?.ID}, ${()=>setSelectedPlace()})"
                    />
                    <label for=${n?.ID}>
                    <h3 class="big-title">
                        ${n?.post_title}
                    </h3></label
                    >
                </div>
              </div>
              <div class="card-body p-0">
                <div class="info-wrapper">
                  <span class="info-wrapper__label">Sportello</span>
                  <p class="info-wrapper__value">CIE</p>
                </div>
                <div class="info-wrapper">
                  <span class="info-wrapper__label">Indirizzo</span>
                  <p class="info-wrapper__value">
                  ${n?.indirizzo}
                  </p>
                </div>
                <div class="info-wrapper">
                    <span class="info-wrapper__label">Apertura</span>
                    <p class="info-wrapper__value">
                    ${n?.apertura}
                    </p>
                </div>
              </div>
            </div>
          </div>
          `}}).catch(e=>{console.log("err",e)}),fetch("/wp-json/wp/v2/servizi/ufficio?"+e).then(e=>e.json()).then(e=>{document.querySelector("#motivo-appuntamento").innerHTML='<option selected="selected" value="">Seleziona opzione</option>';for(const t of e)document.querySelector("#motivo-appuntamento").innerHTML+=`
          <option value="${t?.post_title}">${t?.post_title}</option>
          `}).catch(e=>{console.log("err",e)})):document.querySelector("#place-cards-wrapper").innerHTML=""}),document.getElementById("appointment")),setSelectedPlace=(appointment.addEventListener("change",()=>{answers.appointment=null,checkMandatoryFields(),fetch(url+(`?month=${appointment?.value}&office=`+answers?.place?.id)).then(e=>{if(e.ok)return e.json();throw new Error("HTTP error "+e.status)}).then(e=>{document.querySelector("#radio-appointment").innerHTML="";for(const s of e){var{startDate:t,endDate:n}=s,a=t.split("T")[0],a=new Date(a).toLocaleString([],{weekday:"long",day:"2-digit",month:"long",year:"numeric"}),r=t+"/"+n,n=encodeURIComponent(JSON.stringify({startDate:t,endDate:n}));document.querySelector("#radio-appointment").innerHTML+=`
        <div
        class="radio-body border-bottom border-light"
        >
        <input name="radio" type="radio" id="${r}" onclick="saveAnswerByValue('appointment', '${n}', true)"/>
        <label for="${r}" class="text-capitalize">${a} ore ${t.split("T")[1]}</label>
        </div>
        `}}).catch(e=>{console.log("err",e)})}),()=>{var e=answers?.place;document.querySelector("#selected-place-card").innerHTML=`
  <div class="cmp-info-summary bg-white mb-4 mb-lg-30 p-4">
  <div class="card">
      <div
      class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end"
      >
      <h3 class="title-large-semi-bold mb-3">
        ${e?.nome}
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
            ${e?.indirizzo}
          </p>
          </div>
      </div>
      <div class="single-line-info border-light">
          <div class="text-paragraph-small">Apertura</div>
          <div class="border-light">
          <p class="data-text">
            ${e?.apertura}
          </p>
          </div>
      </div>
      </div>
      <div class="card-footer p-0"></div>
  </div>
  </div>
</div>
  `}),serviceSelect=document.getElementById("motivo-appuntamento"),moreDetailsText=(serviceSelect.addEventListener("change",()=>{saveAnswerByValue("service",serviceSelect?.value)}),document.getElementById("form-details")),nameInput=(moreDetailsText.addEventListener("input",()=>{saveAnswerByValue("moreDetails",moreDetailsText?.value)}),document.getElementById("name")),surnameInput=(nameInput.addEventListener("input",()=>{saveAnswerByValue("name",nameInput?.value)}),document.getElementById("surname")),emailInput=(surnameInput.addEventListener("input",()=>{saveAnswerByValue("surname",surnameInput?.value)}),document.getElementById("email")),getDay=(emailInput.addEventListener("input",()=>{saveAnswerByValue("email",emailInput?.value)}),()=>{var e=answers?.appointment?.startDate?.split("T")[0];return new Date(e).toLocaleString([],{weekday:"long",day:"2-digit",month:"long",year:"numeric"})}),getHour=()=>{var e=answers?.appointment;return[e?.startDate?.split("T")[1],e?.endDate?.split("T")[1]]},setReviews=()=>{document.getElementById("review-office").innerHTML=answers?.office,document.getElementById("review-place").innerHTML=answers?.place?.nome,document.getElementById("review-date").innerHTML=getDay(),document.getElementById("review-hour").innerHTML=getHour()[0]+" - "+getHour()[1],document.getElementById("review-service").innerHTML=answers?.service,document.getElementById("review-details").innerHTML=answers?.moreDetails,document.getElementById("review-name").innerHTML=answers?.name,document.getElementById("review-surname").innerHTML=answers?.surname,document.getElementById("review-email").innerHTML=answers?.email},checkMandatoryFields=()=>{switch(currentStep){case 1:answers?.office&&answers?.place?btnNext.disabled=!1:btnNext.disabled=!0;break;case 2:answers?.appointment?btnNext.disabled=!1:btnNext.disabled=!0;break;case 3:answers?.service&&answers?.moreDetails?btnNext.disabled=!1:btnNext.disabled=!0;break;case 4:answers?.name&&answers?.surname&&answers?.email?btnNext.disabled=!1:btnNext.disabled=!0}};function successFeedback(){document.getElementById("form-steps").classList.add("d-none"),document.getElementById("email-recap").innerText=answers?.email,document.getElementById("date-recap").innerText=` ${getDay()} dalle ore ${getHour()[0]} alle ore `+getHour()[1],document.getElementById("final-step").classList.remove("d-none")}const confirmAppointment=()=>{fetch(urlConfirm,{method:"POST",body:JSON.stringify(answers)}).then(e=>{if(e.ok)return e.json();throw new Error("HTTP error "+e.status)}).then(e=>{successFeedback();var t=document.querySelector("#main-container");t&&t.scrollIntoView({behavior:"smooth"})}).catch(e=>{console.log("err",e)})};