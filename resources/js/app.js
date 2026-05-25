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
                top: 1810,
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
        function checkTextareaHeight(){
            fillInTheBlanksTextarea.style.height = 'auto';
            const textareaHeight = fillInTheBlanksTextarea.scrollHeight;
            fillInTheBlanksTextarea.style.height = textareaHeight + 'px';
        }
        checkTextareaHeight();
        fillInTheBlanksTextarea.addEventListener('input',checkTextareaHeight);

        function checkFITBTextarea(){
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
        }

        fillInTheBlanksTextarea.addEventListener('input', checkFITBTextarea);
        checkFITBTextarea();
    }

    const welcomeForm = document.getElementById('welcome-form');
    if(welcomeForm) {
        function checkInput(e, inputName, elementName, lengthLimit){
            const input = document.getElementById(inputName);

            let error= '';

            if(!input || input.value === '') {
                error = elementName +  " can't be empty";
            } else if (input.value.length >= lengthLimit) {
                error = elementName +  " can't be longer than " + lengthLimit + " characters.";
            } else if (hasSpecialChar(input.value)) {
                error = elementName + " can't have special characters";
            }

            if (error !== '') {
                e.preventDefault();
                const closestDiv = input.closest("div");
                const div = document.createElement("div");
                closestDiv.appendChild(div);
                div.className = "inputError d-flex";
                div.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"red\" class=\"bi bi-exclamation-circle mt-1 me-1\" viewBox=\"0 0 16 16\">" +
                    "<path d=\"M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16\"/>" +
                    "<path d=\"M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z\"/>" +
                    "</svg>";
                div.innerHTML += "<p class='text-danger'>" + error + "</p>";
            }

            function hasSpecialChar(text) {
                return /[!@#$%^&*()+=\[\]{};':"\\|,.<>\/?]/.test(text);
            }
        }

        welcomeForm.addEventListener('submit', function(e) {
            welcomeForm.querySelectorAll('.inputError').forEach(element => element.innerHTML = '');
            checkInput(e,"wsht-name","Name",30);
            checkInput(e,"wsht-theme","Topic",50);
        });
    }
});

// Archive search
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        const table = document.querySelectorAll('table tr.content-row');

        searchInput.addEventListener('input', function() {
           table.forEach(row=> {
               let rowContent = '';

               row.querySelectorAll('.search-td').forEach(content => {
                   rowContent += content.innerText.toLowerCase() + ' ';
               });

               if (rowContent.includes(searchInput.value.toLowerCase())) {
                   row.classList.remove('d-none');
               } else {
                   row.classList.add('d-none');
               }
            });
        });

    }
});


