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

import logoPath from "../images/back.png";

let switchFr = document.getElementById("switchFr");
let switchEn = document.getElementById("switchEn");
let matches = document.querySelectorAll(".translate");

switchEn.onclick = function (e) {
  matches.forEach(function (item) {
    if (
      item.hasAttribute("data-trad") &&
      item.getAttribute("data-lang") == "EN"
    ) {
      let txt = item.innerText;
      item.innerText = item.getAttribute("data-trad");
      item.setAttribute("data-lang", "FR");
      item.setAttribute("data-trad", txt);
    }
  });
};

switchFr.onclick = function (e) {
  matches.forEach(function (item) {
    if (
      item.hasAttribute("data-trad") &&
      item.getAttribute("data-lang") == "FR"
    ) {
      let txt = item.innerText;
      item.innerText = item.getAttribute("data-trad");
      item.setAttribute("data-lang", "EN");
      item.setAttribute("data-trad", txt);
    }
  });
};

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
}

let validates = document.getElementsByClassName("validate");
let deletes = document.getElementsByClassName("delete");


for (var i = 0; i < validates.length; i++) {
  validates[i].addEventListener("click",  function (e) {
    let result = confirm("Are you sure you wanna confirm this inscription Boo ?");
    if (result != true) {
      e.preventDefault();
      
    } 
  });
}


for (var i = 0; i < deletes.length; i++) {
  deletes[i].addEventListener("click",  function (e) {
    let result = confirm("Are you sure you wanna delete this inscription Boo ?");
    if (result != true) {
      e.preventDefault();
    } 
  });
}
