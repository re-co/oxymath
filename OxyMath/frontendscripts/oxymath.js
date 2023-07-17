addEventListener("DOMContentLoaded", (event) => {
    function customArrowControlsInit(){
        const ev = new Event("change");
        var plusButtons, minusButtons;
        plusButtons  = document.querySelectorAll('[data-mathplus]');
        minusButtons  = document.querySelectorAll('[data-mathminus]');
        plusButtons.forEach(b=>{
            b.addEventListener('click', function(e) {
                var target, t, step;
                t = b.getAttribute("data-mathplus");
                target = document.querySelector(`input[data-mathref="${t}"`);
                if(!target) return;
                step = target.getAttribute('step');
                target.value = Number(target.value) + Number(step);
                target.dispatchEvent(ev);
            });
        });
        minusButtons.forEach(b=>{
            b.addEventListener('click', function(e) {
                var target, t, step;
                t = b.getAttribute("data-mathminus");
                target = document.querySelector(`input[data-mathref="${t}"`);
                if(!target) return;
                step = target.getAttribute('step');
                target.value = Number(target.value) - Number(step);
                target.dispatchEvent(ev);
            });
        });
    }
    function selectOnChange(){
        var selects = document.querySelectorAll(`select[data-mathref]`);
        selects.forEach( s =>{
            s.addEventListener("change", oxymath)
        })
    }
    function mathflowCalc(str) {
        const paramsPattern = /[^{}]+(?=})/g;
        let extractParams = str.match(paramsPattern);
        extractParams.forEach(p => {
            var inp = document.querySelector(`[data-mathref="${p}"`);
            if (inp) {
                str = str.replaceAll(p.toString(), inp.value.toString());
            }
            else {
                str = str.replaceAll(p.toString(), '')
            }
        })
        str = str.replaceAll('{', '');
        str = str.replaceAll('}', '');
        str = str.trim();
        var result = Function("return " + str)(); 
        return result;
    }


    window.oxymath = function () {
        if (jQuery('html').attr('ng-app') == 'CTFrontendBuilder') return;
        var mathOutputs = document.querySelectorAll('[data-mathout]');
        mathOutputs.forEach(output => {
            var text = mathflowCalc(output.getAttribute('data-mathout'));
            if(output.getAttribute("data-mathround")){
                var round = output.getAttribute("data-mathround");
                text = Number.parseFloat(text).toFixed(round);
            }
            output.innerText = text;
            if (output.getAttribute('data-ffmirror')) {
                var mirror = output.getAttribute('data-ffmirror');
                var ff1 = document.querySelector(`input[name="${mirror}"]`);
                var ff2 = document.querySelector(`input[data-name="${mirror}"]`);
                if (ff1) {
                    ff1.value = mathflowCalc(output.getAttribute('data-mathout'));
                }
                else if (ff2) {
                    ff2.value = mathflowCalc(output.getAttribute('data-mathout'));
                }
            }
        })

    }
    oxymath();
    customArrowControlsInit();
    selectOnChange();

});
//data-ffmirror => accepts Fluent Form field name where output will be mirrored for submission
//data-mathout => makes any element output, write calc formula under value of this attribute
//data-mathround => round number, pick number of decimal points
//data-mathplus => value is reference to input to increment
//data-mathminus => value is reference to input to decrement