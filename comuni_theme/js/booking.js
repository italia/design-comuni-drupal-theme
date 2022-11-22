function appointment(){var e,i=document.querySelector(".section-wrapper"),r=1,o=document.querySelector('[data-index="'.concat(r,'"]')),s=document.querySelector('[data-progress="'.concat(r,'"]')),l=i.querySelector(".btn-next-step"),d=i.querySelector(".btn-back-step");i&&(e=i.querySelectorAll(".saveBtn"),o.classList.add("d-lg-block"),s.classList.remove("d-none"),e.forEach(function(e){e.classList.add("invisible")}),l&&l.addEventListener("click",function(){var e,t,a,n;d.disabled=!1,e=i.querySelectorAll(".saveBtn"),t=i.querySelectorAll("[data-steps]"),a=i.querySelector('[data-steps="'.concat(r+1,'"]')),n=i.querySelector("[data-steps].active"),o.classList.remove("d-lg-block"),s.classList.remove("d-block"),s.classList.add("d-none"),r==t.length?E():(n.classList.add("d-none"),n.classList.remove("active"),a.classList.add("active"),a.classList.remove("d-none"),document.getElementById("form-steps").scrollIntoView({behavior:"smooth"}),r+=1,L(),(s=document.querySelector('[data-progress="'.concat(r,'"]'))).classList.add("d-block"),s.classList.remove("d-none"),r<t.length&&(o=document.querySelector('[data-index="'.concat(r,'"]'))).classList.add("d-lg-block"),r==t.length&&i.classList.remove("offset-lg-1"),r==t.length&&(l.disabled=!1,i.querySelector(".steppers-btn-confirm span").innerHTML="Invia",e.forEach(function(e){e.classList.remove("invisible"),e.classList.add("visible"),b()})))}),d)&&d.addEventListener("click",function(){var e,t,a,n;l.disabled=!1,e=i.querySelectorAll(".saveBtn"),t=i.querySelectorAll("[data-steps]"),a=i.querySelector("[data-steps].active"),n=i.querySelector('[data-steps="'.concat(r-1,'"]')),1!=r&&(n.classList.remove("d-none"),n.classList.add("active"),a.classList.add("d-none"),a.classList.remove("active"),o.classList.remove("d-lg-block"),s.classList.add("d-none"),--r,(s=document.querySelector('[data-progress="'.concat(r,'"]'))).classList.toggle("d-none"),i.querySelector(".steppers-btn-confirm span").innerHTML="Avanti",r<t.length&&((o=document.querySelector('[data-index="'.concat(r,'"]'))).classList.add("d-lg-block"),i.classList.add("offset-lg-1")),r<t.length&&e.forEach(function(e){e.classList.remove("visible"),e.classList.add("invisible")}),1==r)&&(d.disabled=!0)});const c={},p=(e,t,a=!1)=>{a?(a=decodeURIComponent(t),a=JSON.parse(a),c[e]=a):c[e]=t,"office"==e&&(c.place=null),L()},t=document.getElementById("office-choice"),m=(t.addEventListener("change",()=>{var e;p("office",t?.value),t?.value?(e=encodeURI(t.value),fetch(`/api/v1/ufficio/${e}/sedi`).then(e=>e.json()).then(({data:e})=>{document.querySelector("#place-cards-wrapper").innerHTML="";var{sede_principale:e,altre_sedi:t}=e[0];for(const i of e.concat(t)){var a={nome:i.title,indirizzo:i.indirizzo,apertura:i.orario_apertura,id:i.id},n=document.querySelector("#place-cards-wrapper");n.innerHTML+=`
            <div class="cmp-info-radio radio-card">
              <div class="card p-3 p-lg-4">
                <div class="card-header mb-0 p-0">
                  <div class="form-check m-0">
                    <input
                      class="radio-input"
                      name="beneficiaries"
                      type="radio"
                      id=${i?.id}
                      value='${JSON.stringify(a)}'
                    />
                    <label for=${i?.id}>
                    <h3 class="big-title">
                      ${i?.title}
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
                      ${i?.indirizzo}
                    </p>
                  </div>
                  <div class="info-wrapper info-orari">
                    <span class="info-wrapper__label">Apertura</span>
                    <div class="info-wrapper__value">
                      ${i?.orario_apertura?i.orario_apertura:"non disponibile"}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            `;for(input of n.getElementsByTagName("input"))input.onclick=()=>{var e=i?.id,e=document.getElementById(e)?.value;c.place=JSON.parse(e),u(),L()}}}).catch(e=>{console.error("err",e)}),fetch("/api/v1/servizi/canale/"+e).then(e=>e.json()).then(e=>{document.querySelector("#motivo-appuntamento").innerHTML='<option selected="selected" value="">Seleziona opzione</option>';for(const t of e)document.querySelector("#motivo-appuntamento").innerHTML+=`
            <option value="${t?.title}">${t?.title}</option>
            `}).catch(e=>{console.error("err",e)})):document.querySelector("#place-cards-wrapper").innerHTML=""}),document.getElementById("appointment")),u=(m.addEventListener("change",()=>{c.appointment=null,L(),fetch("/modules/custom/design-comuni-drupal-theme/comuni_theme/assets/mocks/appuntamenti.json").then(e=>{if(e.ok)return e.json();throw new Error("HTTP error "+e.status)}).then(e=>{e=e[m?.value];var t=document.querySelector("#radio-appointment");t.innerHTML="";for(const o of e){var{startDate:a,endDate:n}=o,i=a.split("T")[0],i=new Date(i).toLocaleString("it-IT",{weekday:"long",day:"2-digit",month:"long",year:"numeric"}),r=a+"/"+n;const s=encodeURIComponent(JSON.stringify({startDate:a,endDate:n}));t.innerHTML+=`
          <div class="radio-body border-bottom border-light">
          <input name="radio" type="radio" id="${r}" />
          <label for="${r}" class="text-capitalize">${i} ore ${a.split("T")[1]}</label>
          </div>
          `;for(input of t.getElementsByTagName("input"))input.onclick=()=>p("appointment",s,!0)}}).catch(e=>{console.error("err",e)})}),()=>{var e=c?.place;document.querySelector("#selected-place-card").innerHTML=`
    <div class="cmp-info-summary bg-white mb-4 mb-lg-30 p-4">
    <div class="card">
      <div class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between d-flex justify-content-end">
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
              <div class="data-text">
                ${e?.apertura?e.apertura:"non disponibile"}
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer p-0"></div>
    </div>
    </div>
  </div>
    `}),a=document.getElementById("motivo-appuntamento"),n=(a.addEventListener("change",()=>{p("service",a?.value)}),document.getElementById("form-details")),v=(n.addEventListener("input",()=>{p("moreDetails",n?.value)}),document.getElementById("name")),g=(v.addEventListener("input",()=>{p("name",v?.value)}),document.getElementById("surname")),f=(g.addEventListener("input",()=>{p("surname",g?.value)}),document.getElementById("email")),y=(f.addEventListener("input",()=>{p("email",f?.value)}),()=>{var e=c?.appointment?.startDate?.split("T")[0];return new Date(e).toLocaleString("it-IT",{weekday:"long",day:"2-digit",month:"long",year:"numeric"})}),h=()=>{var e=c?.appointment;return[e?.startDate?.split("T")[1],e?.endDate?.split("T")[1]]},b=()=>{var e=(t=c?.appointment)?.startDate?.split("T")[0],e=new Date(e).toLocaleString("it-IT",{weekday:"long",day:"2-digit",month:"long",year:"numeric"}),t=t?.startDate?.split("T")[1]+" - "+t?.endDate?.split("T")[1];document.getElementById("review-office").innerText=c?.office,document.getElementById("review-place").innerText=c?.place?.nome,document.getElementById("review-date").innerText=y(),document.getElementById("review-hour").innerText=h()[0]+" - "+h()[1],document.getElementById("review-date").innerText=e,document.getElementById("review-hour").innerText=t,document.getElementById("review-service").innerText=c?.service,document.getElementById("review-details").innerText=c?.moreDetails,document.getElementById("review-name").innerText=c?.name,document.getElementById("review-surname").innerText=c?.surname,document.getElementById("review-email").innerText=c?.email},L=()=>{switch(r){case 1:c?.office&&c?.place?l.disabled=!1:l.disabled=!0;break;case 2:c?.appointment?l.disabled=!1:l.disabled=!0;break;case 3:c?.service&&c?.moreDetails?l.disabled=!1:l.disabled=!0;break;case 4:c?.name&&c?.surname&&c?.email?l.disabled=!1:l.disabled=!0}},E=()=>{!async function(){try{return await(await fetch("session/token")).text()}catch(e){console.error(e)}}().then(e=>{fetch("/api/v1/create/appuntamento",{method:"POST",body:JSON.stringify(c),headers:{"Content-Type":"application/json","X-CSRF-Token":e}}).then(e=>{if(!e.ok)throw new Error("HTTP error "+e.status);var t;document.getElementById("form-steps").classList.add("d-none"),document.getElementById("email-recap").innerText=c?.email,document.getElementById("date-recap").innerText=`
      ${y()} dalle ore ${h()[0]} alle ore ${h()[1]}
    `,document.querySelector(".cmp-hero").classList.add("d-none"),(t=(e=document.getElementById("final-step")).querySelector(".address-wrapper")).querySelector(".title-small").innerHtml=`
    <a href="#"
      aria-label="Vai a ${c?.place?.nome}"
      title="Vai a ${c?.place?.nome}"
      class="" data-focus-mouse="false"
    >${c?.place?.nome}</a>
    `,t.querySelector(".subtitle-small").innerText=c?.place?.indirizzo,e.classList.remove("d-none"),e.scrollIntoView({behavior:"smooth"}),fetch("/api/v1/servizio/dettaglio/"+c.service).then(e=>e.json()).then(e=>{e=e[0].cosa_serve,document.getElementById("needed").innerHtml=""+e}).catch(e=>console.error(e))}).catch(e=>{console.error("err",e)})})}}document.getElementById("form-steps")&&appointment();