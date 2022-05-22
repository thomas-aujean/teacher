/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./scss/app.scss";

// start the Stimulus application
import "./bootstrap";

let test = document.getElementById("test");
if (test) {
  let inscription_type = document.getElementById("inscription_type");
  let inscription_weeks = document.getElementById("inscription_weeks");
  let mainSelect = document.getElementById("inscription_workshopChoice");
  let url = test.getAttribute("data-url");

  let datas = {
    type: inscription_type.value,
    weeks: inscription_weeks.value,
  };

  async function ajaxUpdate(data, url) {
    console.log(data);

    removeOptions(mainSelect);

    const response = await fetch(url, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    const result = await response.json();

    let results = Object.values(result.workshops);

    console.log(results);

    if (results.length == 0) {
      console.log("ououo");
      var opt = document.createElement("option");
      opt.value = null;
      opt.innerHTML = "Il n'y a pas d'ateliers correspondant à votre recherche";
      mainSelect.appendChild(opt);
    } else {
      results.forEach(function (workshop) {
        let ateliers = Object.values(workshop.workshops);
        if (ateliers.length == 1) {
          ateliers.forEach(function (w) {
            var opt = document.createElement("option");
            opt.value = workshop.id;
            opt.innerHTML = w.label;
            mainSelect.appendChild(opt);
          });
        } else {

          var opt = document.createElement("option");
          opt.value = workshop.id;
          opt.innerHTML = ateliers[0].label;
          mainSelect.appendChild(opt);
        }
      });
    }
  }

  ajaxUpdate(datas, url);

  inscription_type.onchange = function (e) {
    datas.type = this.value;
    ajaxUpdate(datas, url);
  };

  inscription_weeks.onchange = function (e) {
    datas.weeks = this.value;
    ajaxUpdate(datas, url);
  };

  function removeOptions(selectElement) {
    var i,
      L = selectElement.options.length - 1;
    for (i = L; i >= 0; i--) {
      selectElement.remove(i);
    }
  }

  // using the function:
}
