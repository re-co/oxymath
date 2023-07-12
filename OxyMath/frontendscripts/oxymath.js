addEventListener("DOMContentLoaded", (event) => {

    function mathflowCalc(str) {
        const paramsPattern = /[^{}]+(?=})/g;
        let extractParams = str.match(paramsPattern);
        extractParams.forEach(p => {
            var inp = document.querySelector(`[data-mathref="${p}"`);
            if (inp) {
                str = str.replaceAll(p.toString(), inp.value.toString())
                console.log(p);
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


    window.codaMathForm = function () {
        if (jQuery('html').attr('ng-app') == 'CTFrontendBuilder') return;
        var mathOutputs = document.querySelectorAll('[data-mathout]');
        mathOutputs.forEach(output => {
            var text = mathflowCalc(output.getAttribute('data-mathout'));
            if(output.getAttribute("data-mathround")){
                var round = output.getAttribute("data-mathround");
                text = Number.parseFloat(text).toFixed(round);
            }
            console.log(text);
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
    codaMathForm();

});
//data-ffmirror
//data-mathout
//data-mathformat => format currency
//data-mathround => round number, pick number of decimal points
