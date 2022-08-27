let form = document.getElementById("form");
let title = document.getElementById("title");
let feedbackMain = document.getElementById("feedback-main");
let categoryPicker = document.getElementById("category-picker");
let submitBtn = document.getElementById("feedback-submit-btn");
let severitySlider = null;
let severityLabel = null;
let bugReport = null;
let bugReportGood = false;
let formHasName = false;

form.onsubmit = (e) => {
    if (bugReport) {
        if (bugReport.textLength > 0) {
            bugReportGood = true;
        }
    }
    formHasName = title.value != "";
    if (!bugReportGood || !formHasName) {
        e.preventDefault();
        alert("You need to complete the form.");
    }
}

categoryPicker.onchange = (e) => {
    switch (categoryPicker.value) {
        case "Bug":
            feedbackMain.innerHTML = `
<fieldset class="grid w-11/12 grid-rows-2 ml-auto mr-auto mt-5 mb-5">
    <p class="text-center text-lg">Please describe the bug</p>
    <textarea class="w-full border-2 border-sky-300 outline-sky-300 resize-none p-2" placeholder="Type here..." id="bug-report" name="content"></textarea>
    <div class="w-9/12 ml-auto mr-auto mt-5 mb-5">
        <p>Bug Severity: <span id="bug-severity-label">1</span></p>
        <input type="range" min="1" max="10" value="1" name="bug-severity" class="slider" id="bug-severity-slider"/>
    </div>
</fieldset>
            `;
            bugReport = document.getElementById("bug-report");
            submitBtn.disabled = false;
            severitySlider = document.getElementById("bug-severity-slider");
            severityLabel = document.getElementById("bug-severity-label");
            severitySlider.oninput = (e) => {
                severityLabel.innerHTML = severitySlider.value;
            }
            break;
        case "Pick One":
            feedbackMain.innerHTML = "";
            submitBtn.disabled = true;
            break;
    }
};