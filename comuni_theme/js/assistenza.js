!(function () {
  const l = document.querySelector(".container-assistenza");
  async function n() {
    try {
      var e = l.querySelector('[name="name"]').value,
        r = l.querySelector('[name="surname"]').value,
        t = l.querySelector('[name="email"]').value,
        n = l.querySelector("#category").value,
        o = l.querySelector("#service").value,
        a = l.querySelector("#description").value,
        c = { title: "ticket_" + new Date().toISOString(), nome: e, cognome: r, email: t, categoria: n, servizio: o, descrizione: a };
      for (entry of Object.values(c)) if (!entry) return { success: !1, error: "non sono ammessi campi vuoti" };
      var i,
        s = await (async function () {
          try {
            return await (await fetch("session/token")).text();
          } catch (e) {
            console.error(e);
          }
        })();
      return s
        ? (i = await fetch("./api/v1/create/ticket", { method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-Token": s }, redirect: "follow", referrerPolicy: "no-referrer", body: JSON.stringify(c) })).ok
          ? { success: !0, error: null }
          : { success: !1, error: await i.json() }
        : { success: !1, error: "no csrf token" };
    } catch (e) {
      console.error(e);
    }
  }
  async function e() {
    const t = l.querySelector(".steppers-content");
    if (t) {
      var e = t.querySelector("#category");
      if (e) {
        const o = t.querySelector("#service");
        o &&
          (e.addEventListener("change", async (e) => {
            (t = o), (r = t.firstElementChild), (t.innerHTML = ""), t.append(r), (t.disabled = !0);
            var r = e.target.value;
            if (r) {
              var t = await (async function (e) {
                try {
                  return await (await fetch("./api/v1/servizi" + (e ? "/" + e : ""))).json();
                } catch (e) {
                  console.error(e);
                }
              })(r);
              if (Array.isArray(t)) {
                for (servizio of t) {
                  var n = document.createElement("option");
                  (n.value = servizio.title), (n.text = servizio.title), o.add(n);
                }
                1 < o.childElementCount && (o.disabled = !1);
              }
            }
          }),
          t.addEventListener("submit", async () => {
            var e,
              r = t.querySelector(".errorFeedback"),
              r = (r && r.remove(), await n());
            r.success
              ? (document.getElementById("first-step").classList.add("d-none"),
                (document.getElementById("email-recap").innerText = l.querySelector('[name="email"]').value),
                document.querySelector(".cmp-hero").classList.add("d-none"),
                document.getElementById("second-step").classList.remove("d-none"),
                (e = document.querySelector(".menu-wrapper")) && e.scrollIntoView({ behavior: "smooth" }))
              : (e = (function (e) {
                  var r;
                  if ("non sono ammessi campi vuoti" !== e)
                    return (
                      (e = document.createElement("p")).classList.add("form-feedback", "just-validate-error-label", "ms-0"),
                      (e.innerText = "something went wrong, try again"),
                      (r = document.createElement("div")).classList.add("errorFeedback"),
                      r.appendChild(e),
                      r
                    );
                })(r.error)) &&
                (r = t.querySelector(".privacy-wrapper")) &&
                t.insertBefore(e, r);
          }));
      }
    }
  }
  l && e();
})();
