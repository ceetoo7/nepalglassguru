document.addEventListener("DOMContentLoaded", function () {
    const sectionsContainer = document.getElementById('sections-container');
    const prices = {
        '5mm': { 'black': 1100, 'blue': 115, 'clear': 120, 'green': 125 },
        '6mm': { 'black': 140, 'blue': 145, 'clear': 150, 'green': 155 },
        '8mm': { 'black': 190, 'blue': 195, 'clear': 200, 'green': 205 },
        '10mm': { 'black': 250, 'blue': 255, 'clear': 260, 'green': 265 },
        '12mm': { 'black': 300, 'blue': 305, 'clear': 310, 'green': 315 }
    };

    // Create a new section
    function createSection() {
        const section = document.createElement('div');
        section.className = 'section';
        section.innerHTML = `
            <div class="selectors">
                <select class="unit-selector">
                    <option value="inches">Inches</option>
                    <option value="cm">Cm</option>
                </select>
                <select class="thickness-selector">
                    <option value="5mm">5mm</option>
                    <option value="6mm">6mm</option>
                    <option value="8mm">8mm</option>
                    <option value="10mm">10mm</option>
                    <option value="12mm">12mm</option>
                </select>
                <select class="color-selector">
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="clear">Clear</option>
                    <option value="green">Green</option>
                </select>
                <button id="remove-btn" onclick="removeSection(this)">&times;Section</button>
            </div>
            <div class="input-container">
                <div class="input-group">
                    <input type="number" placeholder="Length" class="length">
                    <input type="number" placeholder="Breadth" class="breadth">
                    <button class="remove-btn" onclick="removeGroup(this)">&times;</button>
                    <div class="result-display"></div>
                </div>
            </div>
            <button class="add-box-btn" onclick="addInputGroup(this)">+</button><hr>
            
        `;
        sectionsContainer.appendChild(section);
    }

    // Add input group within a section
    window.addInputGroup = function (button) {
        const section = button.closest('.section');
        const inputContainer = section.querySelector('.input-container');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group';
        inputGroup.innerHTML = `
            <input type="number" placeholder="Length" class="length">
            <input type="number" placeholder="Breadth" class="breadth">
            <button class="remove-btn" onclick="removeGroup(this)">&times;</button>
            <div class="result-display"></div>
        `;
        inputContainer.appendChild(inputGroup);
    }

    // Remove input group
    window.removeGroup = function (button) {
        button.closest('.input-group').remove();
    }
    window.removeSection = function (button) {
        button.closest('.section').remove();
    }

    // Round input based on defined ranges
    function roundInput(value) {
        if (value >= 6 && value <= 9) return 9;
        if (value > 9 && value <= 12) return 12;
        if (value > 12 && value <= 18) return 18;
        if (value > 18 && value <= 24) return 24;
        if (value > 24 && value <= 30) return 30;
        if (value > 30 && value <= 36) return 36;
        if (value > 36 && value <= 42) return 42;
        if (value > 42 && value <= 48) return 48;
        if (value > 48 && value <= 60) return 60;
        if (value > 60 && value <= 72) return 72;
        if (value > 72 && value <= 84) return 84;
        if (value > 84 && value <= 96) return 96;
        if (value > 96 && value <= 108) return 108;
        if (value > 108 && value <= 120) return 120;
        return value;
    }

    // Convert cm to inches
    function convertCmToInches(value) {
        return value / 2.54;
    }

    // Function to calculate total for all sections
    window.calculateTotal = function () {
        const sections = document.querySelectorAll('.section');
        let totalSquareFeet = 0;
        let totalPrice = 0;

        sections.forEach(function (section) {
            const unitSelector = section.querySelector('.unit-selector');
            const thicknessSelector = section.querySelector('.thickness-selector');
            const colorSelector = section.querySelector('.color-selector');
            const inputGroups = section.querySelectorAll('.input-group');

            inputGroups.forEach(function (group) {
                const lengthInput = group.querySelector('.length');
                const breadthInput = group.querySelector('.breadth');
                const resultDisplay = group.querySelector('.result-display');

                let length = parseFloat(lengthInput.value);
                let breadth = parseFloat(breadthInput.value);

                // Convert from cm to inches if necessary
                if (unitSelector.value === 'cm') {
                    length = convertCmToInches(length);
                    breadth = convertCmToInches(breadth);
                }

                // Round the input values
                length = roundInput(length);
                breadth = roundInput(breadth);

                if (!isNaN(length) && !isNaN(breadth)) {
                    const squareFeet = (length * breadth) / 144;
                    totalSquareFeet += squareFeet;

                    const pricePerSqFt = prices[thicknessSelector.value][colorSelector.value];
                    if (pricePerSqFt) {
                        const price = squareFeet * pricePerSqFt;
                        totalPrice += price;

                        resultDisplay.innerHTML = `Sq ft: ${squareFeet.toFixed(2)}, Price: NRS ${price.toFixed(2)}`;
                    } else {
                        console.error(`Price for thickness "${thicknessSelector.value}" and color "${colorSelector.value}" not found.`);
                        resultDisplay.innerHTML = `Error: Price information not available.`;
                    }
                } else {
                    console.error(`Invalid length or breadth: length=${length}, breadth=${breadth}`);
                }
            });
        });

        // Display total result
        document.getElementById('result').innerHTML = `Total Sq ft: ${totalSquareFeet.toFixed(2)}, Total Price: NRS ${totalPrice.toFixed(2)}`;
    }

    // Add new section
    window.addNewSection = function () {
        createSection();
    }

    // Initialize the first section
    createSection();

    // Add event listener for "New Section" button
    document.getElementById('new-section-btn').addEventListener('click', addNewSection);

    // Add event listener for "Calculate Total" button
    document.getElementById('calculate-total-btn').addEventListener('click', calculateTotal);
});
