// will be moved to script folder later

function showTab(n) {

    const x = document.getElementsByClassName("tab");
    x[n].style.display = "block";

    if (n === 0) {
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("step2Btn").style.display = "none";
    } else if(n === 1) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("step2Btn").style.display = "inline";
    }
    if (n === (x.length - 1)) {
        document.getElementById("step2Btn").style.display = "none";
        document.getElementById("regHeader").style.display = "none";
    }
    fixStepIndicator(n);
    getCount();
}


async function nextPrev(n, result = true) {

    let x = document.getElementsByClassName("tab");


    if (currentTab === 0) {
        let resultOfAjax = result;
        if(typeof resultOfAjax === 'object'){
            toggleErrors(resultOfAjax);

            return false;
        } else if(resultOfAjax === 1){
            x[currentTab].style.display = "none";
            toggleErrors(resultOfAjax);
        }
    } else if (currentTab === 1) {
            x[currentTab].style.display = "none";
    }
    currentTab = currentTab + 1;
    sessionStorage.setItem('currentTab', currentTab.toString());
    if (+sessionStorage.getItem('currentTab') === 2) {
        sessionStorage.setItem('currentTab', '0');
    }
    showTab(currentTab);
}

function fixStepIndicator(n) {

    let i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    x[n].className += " active";
}