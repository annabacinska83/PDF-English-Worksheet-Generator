import './bootstrap';
import darkLogo from '../images/dark_logo.png';
import lightLogo from '../images/light_logo.png';

document.addEventListener("DOMContentLoaded",() => {
    const nav = document.getElementById("mainNav");
    const logo = document.getElementById("navLogo");
    const btn = document.getElementById("navButton");
    if(!nav || !logo || !btn) return;

    function onScroll() {
        const scrolled = window.scrollY > 20;

        nav.classList.toggle("navbar-dark", scrolled);
        nav.classList.toggle("navbar-light", !scrolled);

        btn.classList.toggle("btn-light", scrolled);

        logo.src = scrolled ? lightLogo : darkLogo;
    }

    window.addEventListener("scroll", onScroll);
    onScroll();

    const multiSelect = document.getElementById("exerciseTypeMenu");
    if(multiSelect) {
        function checkCheckboxes(checkboxes) {
            const placeholder = document.getElementById("exerciseTypePlaceholder");
            placeholder.innerText = '';

            let numOfChecked = 0;
            checkboxes.forEach(oneCheckbox => {
                if (oneCheckbox.checked) {
                    numOfChecked++;
                }
            });

            checkboxes.forEach(oneCheckbox => {
                if (oneCheckbox.checked) {
                    numOfChecked--;
                    placeholder.innerText += " " + oneCheckbox.value;
                    if(numOfChecked > 0) {
                        placeholder.innerText += ",";
                    }
                }
            });

            if (placeholder.innerText === '') {
                placeholder.innerText = "Select question types";
            }
        }

        const checkboxes = multiSelect.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => checkCheckboxes(checkboxes));
        });
    }

    document.querySelectorAll(".scroll-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            window.scrollTo({
                top: 1650,
                behavior: "smooth"
            });
        });
    });

    function checkFormCheckboxes(checkbox) {
        const targetId = checkbox.dataset.target;

        if (targetId.includes("|")) {
            const targets = targetId.split("|");

            const input1 = document.getElementById(targets[0]);
            const input2 = document.getElementById(targets[1]);

            input1.disabled = !checkbox.checked;
            input2.disabled = !checkbox.checked;
        } else {
            const input = document.getElementById(targetId);
            input.disabled = !checkbox.checked;
        }
    }

    document.querySelectorAll('.task-check').forEach(checkbox => {
        checkbox.addEventListener('change', event => {
            checkFormCheckboxes(event.target);
        });

        // Initialize state on load
        checkFormCheckboxes(checkbox);
    });


    const fillInTheBlanksTextarea = document.getElementById('fillInTheBlanksTextarea');
    if (fillInTheBlanksTextarea) {
        fillInTheBlanksTextarea.addEventListener('input', function () {
            const textareaValue = fillInTheBlanksTextarea.value;
            const regex = /\[(.*?)\]/g;

            const results = textareaValue.match(regex);
            const spanForOptions = document.getElementById('spanForOptions');

            if (results) {
                spanForOptions.innerHTML = "";

                const span = document.createElement("span");
                span.className = "form-label text-muted small mb-2";
                span.textContent = "Answer key";
                spanForOptions.appendChild(span);

                const rowDiv = document.createElement("div");
                rowDiv.className = "row";
                spanForOptions.appendChild(rowDiv);

                let number = 1;

                results.forEach(result => {
                    const text = result.slice(1, -1);

                    const colDiv = document.createElement("div");
                    colDiv.className = "col-12 col-md-4";

                    const innerDiv = document.createElement("div");
                    innerDiv.className = "d-flex align-items-center";

                    const labelSpan = document.createElement("span");
                    labelSpan.className = "text-secondary small shrink-0 pe-2";
                    labelSpan.textContent = "Answer " + number + ":";

                    const input = document.createElement("input");
                    input.name = "fitb-option-text";
                    input.type = "text";
                    input.className = "form-control bg-light border-0 text-center text-muted w-50 mb-2";
                    input.value = text;
                    input.disabled = true;

                    innerDiv.appendChild(labelSpan);
                    innerDiv.appendChild(input);

                    colDiv.appendChild(innerDiv);
                    rowDiv.appendChild(colDiv);

                    number++;
                });
            } else {
                spanForOptions.innerHTML = "";
            }
        });
    }

    const usersTable = document.getElementById("usersTable");
    if (usersTable) {
        document.body.classList.add("body-white");

    }

    const navBar = document.getElementById('mainNav');
    navBar.classList.remove('fixed-top');
    document.body.style.paddingTop = '0';
});


