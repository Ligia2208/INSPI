$( function () {

    

});


    let memory = 0; // Variable de memoria

    function addToDisplay(value) {
        document.getElementById("display").value += value;
    }

    function calculateResult() {
        try {
            document.getElementById("display").value = eval(document.getElementById("display").value);
        } catch (e) {
            alert("Operación inválida");
        }
    }

    function clearDisplay() {
        document.getElementById("display").value = "";
    }

    function addToMemory() {
        memory += parseFloat(document.getElementById("display").value) || 0;
        document.getElementById("memoryValue").innerText = memory;
        clearDisplay();
    }

    function useMemory() {
        document.getElementById("display").value = memory;
    }

    function clearMemory() {
        memory = 0;
        document.getElementById("memoryValue").innerText = memory;
    }