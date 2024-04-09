<?php 
function my_plugin_scripts() {
    ?>
<script>


// Calculation for investment Details
function calculateInvestment(initial_investment, interest_rate, interest_period, interest_year, interest_month) {
    let compound_interval = document.getElementById('compound_interval').value;
    let compound_int;
    // Use a switch statement for cleaner mapping of interval to frequency
  switch (compound_interval) {
    case 'yearly-1':
      compound_int = 1;
      break;
    case 'yearly-2':
      compound_int = 2;
      break;
    case 'quarterly-4':
      compound_int = 4;
      break;
    case 'monthly-6':
      compound_int = 6;
      break;
    case 'monthly-12':
      compound_int = 12;
      break;
    case 'monthly-24':
      compound_int = 24;
      break;
    case 'weekly-26':
      compound_int = 26;
      break;
    case 'weekly-52':
      compound_int = 52;
      break;
    case 'weekly-140':
      compound_int = 140;
      break;
    case 'daily-365':
      compound_int = 365;
      break;
    case 'daily-360':
      compound_int = 360;
      break;
    default:
      // Handle invalid interval (optional)
      console.error("Invalid compound interval:", compound_interval);
      break;
  }

  let int_period = document.getElementById('interest_period').value;
  let int_period_value;
  switch(int_period) {
    case 'Daily':
      int_period_value = 365;
      break;
    case 'Weekly':
      int_period_value = 52;
      break;
    case 'Monthly':
      int_period_value = 12;
      break;
    case 'Quarterly':
      int_period_value = 4;
      break;
    case 'Yearly':
      int_period_value = 1;
      break;
    default:
      // Handle invalid interval (optional)
      console.warn("Invalid interest period:", int_period);
      break;
  }

    interest_month > 0 ? interest_month = parseInt(interest_month) : interest_month = 0

    console.log("compound_interval", compound_int, "type of", typeof(compound_int))
    console.log("interest_period", int_period_value, "type of", typeof(int_period_value))
    
    // Convert years and months to total months
    let totalMonths = parseInt(interest_year) * int_period_value + parseInt(interest_month);
    console.log("1st total months", totalMonths)

     // Convert annual interest rate to decimal and monthly interest rate
    let effectiveRate = interest_rate / 100;
    console.log("effective rate", effectiveRate)
    

    let monthlyInterestRate = effectiveRate / compound_int;
    console.log("monthly interest rate", monthlyInterestRate)

    // Calculate total number of compounding periods
    let numberOfPeriods = totalMonths * compound_int;
    console.log("number of periods", numberOfPeriods)

    // Calculate Compound Amount
    let compoundAmount = initial_investment * Math.pow(1 + monthlyInterestRate, numberOfPeriods);
    console.log("compound amount", compoundAmount)

    // Calculate total interest earned
    let totalInterest = compoundAmount - initial_investment;
    console.log("total interest", totalInterest)

    // Calculate all-time rate of return (RoR)
    // let rateOfReturn = ((compoundAmount - initial_investment) / initial_investment) * 100;
    let rateOfReturn = (totalInterest / initial_investment) * 100;
    console.log("rate of return", rateOfReturn)

    // Calculate APY
    let apy = Math.pow(1 + effectiveRate / compound_int, compound_int) - 1;
    apy *= 100; // convert to percentage
    console.log("apy", apy)

    // Prepare data for yearly table rows
    let tableData = [];
    let currentBalance = initial_investment;
    let accruedInterest = 0;
    
    // Row for initial investment details
    tableData.push({
        year: 0,
        interest: '-',
        accruedInterest: '-',
        balance: initial_investment
    });
    
    let months = (parseInt(interest_year) * 12) + parseInt(interest_month);
    console.log("total months", months);


    let year = parseInt(interest_year);
    year = parseInt(interest_month) > 0 ? year+1 : year;
    console.log("year", year);
    // Rows for each interest year starting from the second year
for (let i = 1; i <= year; i++) {
    let monthsInYear = 12; // Total months in a year
    if (i === year && interest_month > 0) {
        monthsInYear = interest_month; // Update months for the last year
        console.log("mothsYear", monthsInYear)
        let cons = interest_month > 0 ? monthsInYear = parseInt(interest_month) : monthsInYear = 0
        console.log("cons", cons)
    }
    let months = (i - 1) * 12 + monthsInYear; // Calculate total months up to this year
    console.log("Total months for year", i, ":", months);
    console.log("months year in out side", monthsInYear)
    let compound_amnt = currentBalance * Math.pow(1 + monthlyInterestRate, monthsInYear);
    let interestEarned = (compound_amnt - currentBalance).toFixed(2);
    accruedInterest += parseFloat(interestEarned);
    currentBalance = (parseFloat(currentBalance) + parseFloat(interestEarned)).toFixed(2);
    
    tableData.push({
        year: i,
        interest: interestEarned,
        accruedInterest: accruedInterest.toFixed(2),
        balance: currentBalance
    });
}

    console.log("tableData", tableData)

    // monthly interest table
    let monthlyTableData = [];
    let monthlyAccruedInterest = 0;
    let monthlyCurrentBalance = initial_investment;

    monthlyTableData.push({
        month: 0,
        interest: '-',
        accruedInterest: '-',
        balance: initial_investment
    });


    // Rows for each month
    for (let i = 1; i <= months; i++) {
        let monthlyInterestEarned = (monthlyCurrentBalance * monthlyInterestRate).toFixed(2);
        monthlyAccruedInterest += parseFloat(monthlyInterestEarned);
        monthlyCurrentBalance = (parseFloat(monthlyCurrentBalance) + parseFloat(monthlyInterestEarned)).toFixed(2);

        monthlyTableData.push({
            month: i,
            interest: monthlyInterestEarned,
            accruedInterest: monthlyAccruedInterest.toFixed(2),
            balance: monthlyCurrentBalance
        });
    }

    console.log("monthly interest table", monthlyTableData)


    return {
        futureValue: compoundAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}), // Format with thousands separators and two decimal places
        totalInterest: totalInterest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}), // Format with thousands separators and two decimal places
        rateOfReturn: rateOfReturn.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + "%", // Rounded to 2 decimal places and formatted as percentage
        apy: apy.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + "%", // APY formatted as percentage
        tableData: tableData,
        monthlyTableData: monthlyTableData
    };

}

// main calculate function
function calculate() {
    // Get the initial investment value from the input field
    let initial_investment = parseFloat(document.getElementById('initial_investment').value);
    let initial_balance = initial_investment.toFixed(2);
    let interest_rate = parseFloat(document.getElementById('interest_rate').value);
    let interest_period = document.getElementById('interest_period').value;
    let interest_year = parseFloat(document.getElementById('interest_year').value); 
    let interest_month = parseFloat(document.getElementById('interest_month').value);
    let compound_interval = document.getElementById('compound_interval').value;

    // Investment Details
    let investmentDetails = calculateInvestment(initial_balance, interest_rate, interest_period, interest_year, interest_month, compound_interval);
    
    // console.log("Future Investment Value: $" + investmentDetails.futureValue);
    // console.log("Total Interest Earned: $" + investmentDetails.totalInterest);
    // console.log("All-Time Rate of Return (RoR): " + investmentDetails.rateOfReturn);
    // console.log("Annual Percentage Yield (APY): " + investmentDetails.apy);
    // console.log("table data", investmentDetails.tableData);

    // // Access the table body
    let tableBody = document.getElementById("tbody");
    // Clear existing table rows
    tableBody.innerHTML = "";

        // Populate table rows with tableData
        investmentDetails.tableData.forEach((data, index) => {
        let row = document.createElement("tr");
        row.style.height = "45px";
        row.style.backgroundColor = "#ffffff";
        // Check if it's the last row
        if (index === investmentDetails.tableData.length - 1) {
            row.style.backgroundColor = "#132813"; // Apply special background color to the last row
            row.style.color = "#ffffff"; // Text color for the last row
            row.style.height = "45px";
        }
        row.innerHTML = `
            <td class="text-center border-b">${data.year}</td>
            <td class="text-left border-b pl-6">${data.interest > 0 ? '$' + data.interest : '-'}</td>
            <td class="text-left border-b pl-6">${data.accruedInterest > 0 ? '$' + data.accruedInterest : '-'}</td>
            <td class="text-left border-b pl-6">$${data.balance}</td>
        `;
        tableBody.appendChild(row);
    });

    let monthTable = document.getElementById("month_tbody");
    // Clear existing table rows
    monthTable.innerHTML = "";

    // Populate table rows with tableData
    investmentDetails.monthlyTableData.forEach((data, index) => {
        let row = document.createElement("tr");
        row.style.height = "45px";
        row.style.backgroundColor = "#ffffff";
        if (index !== 0) { // Exclude the first row
        row.style.color = (index) % 12 === 0 || index === investmentDetails.monthlyTableData.length - 1 ? "#ffffff" : "#000000";
        }
        if (index !== 0) { // Exclude the first row
        row.style.backgroundColor = (index) % 12 === 0 || index === investmentDetails.monthlyTableData.length - 1 ? "#132813" : "#ffffff";
        }
        row.innerHTML = `
            <td class="text-center border-b">${data.month}</td>
            <td class="text-left border-b pl-6">${data.interest > 0 ? '$' + data.interest : '-'}</td>
            <td class="text-left border-b pl-6">${data.accruedInterest > 0 ? '$' + data.accruedInterest : '-'}</td>
            <td class="text-left border-b pl-6">$${data.balance}</td>
        `
        monthTable.appendChild(row);
    });



    // to Display value
    document.getElementById('interest_year_value').textContent = interest_year;
    document.getElementById('interest_month_value').textContent = interest_month > 0 ? interest_month + ' ' + 'Months' : '';
    document.getElementById('interest_rate_value').textContent = interest_rate;
    document.getElementById('interest_period_value').textContent = interest_period;
    document.getElementById('future_value').textContent = investmentDetails.futureValue;
    document.getElementById('total_interest_earned').textContent = investmentDetails.totalInterest;
    document.getElementById('ror').textContent = investmentDetails.rateOfReturn;
    document.getElementById('initial_balance').textContent = initial_balance;

    // Summary Details
    switch (compound_interval) {
    case 'yearly-1':
      compound_int = 'Yearly (1/yr)';
      break;
    case 'yearly-2':
      compound_int = 'Half-Yearly (2/yr)';
      break;
    case 'quarterly-4':
      compound_int = 'Quarterly (4/yr)';
      break;
    case 'monthly-6':
      compound_int = 'Bi-Monthly (6/yr)';
      break;
    case 'monthly-12':
      compound_int = 'Monthly (12/yr)';
      break;
    case 'monthly-24':
      compound_int = 'Semi-Monthly (24/yr)';
      break;
    case 'weekly-26':
      compound_int = 'Bi-Weekly (26/yr)';
      break;
    case 'weekly-52':
      compound_int = 'Weekly (52/yr)';
      break;
    case 'weekly-140':
      compound_int = 'Semi-Weekly (140/yr)';
      break;
    case 'daily-365':
      compound_int = 'Daily (365/yr)';
      break;
    case 'daily-360':
      compound_int = 'Daily (360/yr)';
      break;
    default:
      // Handle invalid interval (optional)
      console.error("Invalid compound interval:", compound_interval);
      break;
  }
    //summary
    document.getElementById('summary_initial_deposit').textContent = '$' + initial_balance;
    document.getElementById('summary_interest_rate').textContent = interest_rate + '%';
    document.getElementById('summary_effective_rate').textContent = investmentDetails.apy;
    document.getElementById('summary_time').textContent = interest_year + ' Years'+ ' ' + (interest_month > 0 ? interest_month + ' Months' : '');
    document.getElementById('summary_compounding').textContent = compound_int;

}

function toggleSummary() {
    var summary = document.getElementById("summary_container");
    var summary_svg = document.getElementById("summary_svg");
    summary.style.display = summary.style.display === "none" ? "block" : "none";
    summary_svg.style.stroke = summary.style.display === "none" ? "#B9B9B9" : "#61CE70";
}

function toggleChart() {

    // Get the canvas element
    let canvas = document.getElementById('myChart');

    // Remove the chart instance if it exists
    if (window.myChart) {
        // Remove reference to the chart instance
        delete window.myChart;
        
        // Clear the canvas
        canvas.width = canvas.width;
        canvas.height = canvas.height;
    }

    // Now, you can create a new chart instance on the canvas
    window.myChart = new Chart(canvas, {
        // Chart configuration options...
        data: {
        datasets: [{
            type: 'bar',
            label: 'Bar Dataset',
            data: [10, 20, 30, 40]
        }, {
            type: 'line',
            label: 'Line Dataset',
            data: [50, 50, 50, 50],
        }],
        labels: ['January', 'February', 'March', 'April']
    },
    });

 

    var breakdown = document.getElementById("breakdown");
    let chart = document.getElementById("chart");
    var table = document.getElementById("table");
    var table_svg = document.getElementById("table_svg");
    var chart_svg = document.getElementById("chart_svg");
    var monthlyTable = document.getElementById("month_data_table");

    table.style.display = "none";
    chart.style.display = "block";
    monthlyTable.style.display = "none";
    breakdown.style.display = "none";
    breakdown.style.color = "#132813";
    breakdown.style.font = "24px"
    table_svg.style.stroke = "#B9B9B9";
    chart_svg.style.stroke = "#61CE70";
}

function toggleTable() {
    var table = document.getElementById("table");
    var chart = document.getElementById("chart");
    var breakdown = document.getElementById("breakdown");
    var table_svg = document.getElementById("table_svg");
    var chart_svg = document.getElementById("chart_svg");

    table.style.display = "block";
    chart.style.display = "none";
    breakdown.style.display = "block";
    table_svg.style.stroke = "#61CE70";
    chart_svg.style.stroke = "#B9B9B9";
}

function changeStyle(currency) {
    // Reset all elements to default style
    var currencies = ["$", "€", "£", "₹", "¥"]; // Add more currencies if needed
    currencies.forEach(function(curr) {
        var element = document.getElementById(curr);
        if (element) {
            element.style.backgroundColor = '#EBEBEB';
            element.style.color = '#132813';
        }
    });

    // Apply style to the selected currency
    var selectedElement = document.getElementById(currency);
    if (selectedElement) {
        selectedElement.style.backgroundColor = '#132813';
        selectedElement.style.color = '#ffffff';

    }
    // Update all elements with name "currency"
    var currencyElements = document.getElementsByName("currency")
    for (var i = 0; i < currencyElements.length; i++) {
        currencyElements[i].innerHTML = currency;
    }
}

// Add an event listener for when the DOM content is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Initially display the deposit amount and annual deposit sections
    document.getElementById("depositSection").style.display = "block";
    document.getElementById("annualDepositSection").style.display = "block";
});

function changeContribution(contribution) {
    // Reset all elements to default style
    let contributions = ["none", "deposits", "withdrawals", "both"];
    contributions.forEach(function(cont) {
        let element = document.getElementById(cont);
        if (element) {
            element.style.backgroundColor = '#EBEBEB';
            element.style.color = '#132813';
        }
    });

    // Hide all sections
    let sections = document.querySelectorAll(".contribution-section");
    sections.forEach(function(section) {
        section.style.display = "none";
    });

    // Highlight selected contribution
    let selectedElement = document.getElementById(contribution);
    if (selectedElement) {
        selectedElement.style.backgroundColor = '#132813';
        selectedElement.style.color = '#ffffff';
    }

    // Show relevant sections based on contribution type
    switch(contribution) {
        case "deposits":
            document.getElementById("depositSection").style.display = "block";
            document.getElementById("depositPeriodSection").style.display = "block";
            document.getElementById("annualDepositSection").style.display = "block";
            break;
        case "withdrawals":
            document.getElementById("withdrawalSection").style.display = "block";
            document.getElementById("annualWithdrawalSection").style.display = "block";
            break;
        case "both":
            document.getElementById("depositSection").style.display = "block";
            document.getElementById("depositPeriodSection").style.display = "block";
            document.getElementById("annualDepositSection").style.display = "block";
            document.getElementById("withdrawalSection").style.display = "block";
            document.getElementById("annualWithdrawalSection").style.display = "block";
            break;
        default:
            // No action needed for "none"
            break;
    }


}

function changePeriod(period) {
    let breakdown = document.getElementById("breakdown_option");
    let yearTable = document.getElementById("year_table");
    let monthTable = document.getElementById("month_table");
    // Reset all elements to default style
    let periods = ["monthly", "yearly"];
    periods.forEach(function(per) {
        let element = document.getElementById(per);
        if (element) {
            element.style.backgroundColor = '#EBEBEB';
            element.style.color = '#132813';
        }
    })

    let selectedElement = document.getElementById(period);
    if (selectedElement) {
        selectedElement.style.backgroundColor = '#132813';
        selectedElement.style.color = '#ffffff';
    }

    let month = periods[0]
    let year = periods[1]

    if (month == period) {
        breakdown.textContent = "Monthly";
        yearTable.style.display = "none";
        monthTable.style.display = "block";
    }else if (year == period) {
        breakdown.textContent = "Yearly";
        yearTable.style.display = "block";
        monthTable.style.display = "none";
    }
    
}

function changeDepositPeriod(deposit_period) {
    // Reset all elements to default style\
    let deposit_periods = ["beginning", "end"];
    deposit_periods.forEach(function(deposit) {
        let element = document.getElementById(deposit);
        if (element) {
            element.style.backgroundColor = '#EBEBEB';
            element.style.color = '#132813';
        }
    })

    let selectedElement = document.getElementById(deposit_period);
    if (selectedElement) {
        selectedElement.style.backgroundColor = '#132813';
        selectedElement.style.color = '#ffffff';
    }
}


function copyFutureValue() {
    // Get the copy icon element
    const copyIcon = document.getElementById("copy_future_value");
    console.log("copy icon working")
    // Get the future value element
    const futureValueElement = document.getElementById("future_value");
    // Create a temporary textarea element to copy the text
    const tempTextarea = document.createElement("textarea");
    tempTextarea.value = futureValueElement.innerText;
    document.body.appendChild(tempTextarea);
    // Select and copy the text
    tempTextarea.select();
    document.execCommand("copy");
    // Remove the temporary textarea
    document.body.removeChild(tempTextarea);
    // Display "Copied" text as a tooltip-like indicator
    copyIcon.style.fill = "#61CE70"; // Change SVG color to #61CE70
    setTimeout(() => {
        copyIcon.style.fill = "#BEBEBE"; // Change SVG color back to default
    }, 2000);
}

function copyTotalInterest() {
    // Get the copy icon element
    const copyIcon = document.getElementById("copy_total_interest");
    console.log("copy icon working")
    // Get the future value element
    const totalInterestElement = document.getElementById("total_interest_earned");
    // Create a temporary textarea element to copy the text
    const tempTextarea = document.createElement("textarea");
    tempTextarea.value = totalInterestElement.innerText;
    document.body.appendChild(tempTextarea);
    // Select and copy the text
    tempTextarea.select();
    document.execCommand("copy");
    // Remove the temporary textarea
    document.body.removeChild(tempTextarea);
    // Display "Copied" text as a tooltip-like indicator
    copyIcon.style.fill = "#61CE70"; // Change SVG color to #61CE70
    setTimeout(() => {
        copyIcon.style.fill = "#BEBEBE"; // Change SVG color back to default
    }, 2000);total_interest_earned
}


// Add event listener to compound interval select box
document.getElementById('compound_interval').addEventListener('change', updateInterestPeriod);

// Add event listener to interest period select box
document.getElementById('deposit_period').addEventListener('change', updateCompoundInterval);



</script>
<?php
}
  
  add_action( 'wp_enqueue_scripts', 'my_plugin_scripts' );
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <title>Document</title>

    <style>
        /* Hide the number spinner */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            /* Optional: Add your additional styles here */
        }

        .flex {
            display: flex;
        }

        .summary-container {
            display: none;
        }

    ::-webkit-scrollbar {
        display: none;
        scrollbar-width: none;
        /* background-color: #ffffff; */
    }

    ::-webkit-scrollbar-track {
        background-color: none;
    }

    ::-webkit-scrollbar-thumb {
        background-color: none;
    }
    </style>
</head>

<body>
    <div class="mt-[48px] px-[178px]">
        <div class="flex flex-col md:flex-row md:flex-wrap lg:flex-nowrap justify-between">
            <!--1st col-->
            <div class="w-full h-full md:w-5/12 pr-3 pb-6">
                <div class="bg-[#F4F4F4] rounded-[8px]">
                    <div class="mt-0">
                        <!--Currency--->
                        <div class="px-[24px]">
                            <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Currency</p>
                            <div class="flex mt-[16px] bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                <div onclick="changeStyle('$')" id="$"
                                    class="w-[60px] bg-[#132813] rounded-l-[8px] text-[16px] text-[#ffffff] border-r border-[#000000]">
                                    <p class="flex cursor-pointer justify-center items-center my-3">$</p>
                                </div>
                                <div onclick="changeStyle('€')" id="€"
                                    class="w-[60px] text-[#132813]  text-[16px] border-r border-[#132813]">
                                    <p class="flex cursor-pointer justify-center items-center my-3">€</p>
                                </div>
                                <div onclick="changeStyle('£')" id="£"
                                    class="w-[60px] text-[#132813]  text-[16px] border-r border-[#132813]">
                                    <p class="flex cursor-pointer justify-center items-center my-3">£</p>
                                </div>
                                <div onclick="changeStyle('₹')" id="₹"
                                    class="w-[60px] text-[#132813]  text-[16px] border-r border-[#132813]">
                                    <p class="flex cursor-pointer justify-center items-center my-3">₹</p>
                                </div>
                                <div onclick="changeStyle('¥')" id="¥"
                                    class="w-[60px] text-[#132813]  text-[16px] border-r border-[#132813]">
                                    <p class="flex cursor-pointer justify-center items-center my-3">¥</p>
                                </div>
                                <!-- Add more currency options as needed -->
                            </div>
                        </div>
                        <!---Initial Investment--->
                        <div class="px-[24px]">
                            <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Initial Investment</p>
                            <div class="flex w-full">
                                <input type="number" value="5000" id="initial_investment"
                                    class="mt-[16px] relative outline-none text-[#132813] pl-[75px] pr-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                <div class="w-[60px] absolute mt-[16px] text-[16px] border-r border-[#132813]">
                                    <p name="currency" class="flex justify-center items-center my-3">$</p>
                                </div>
                            </div>
                        </div>
                        <!---Interest rate-->
                        <div class="px-[24px]">
                            <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Interest rate :</p>
                            <div class="flex">
                                <div class="w-6/12 flex pr-3">
                                    <input type="number" value="5" id="interest_rate"
                                        class="mt-[16px] text-[#132813] relative outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                    <div class="absolute -mt-2 left-[335px]">
                                        <p
                                            class="text-[16px] text-[#132813] flex justify-center items-center my-3 font-normal">
                                            %</p>
                                    </div>
                                </div>
                                <div class="w-6/12 pl-3">
                                    <select id="interest_period"
                                        class="mt-[16px] outline-none text-[#132813] px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <option value="Daily">Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Yearly" selected>Yearly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!---Years and Month-->
                        <div class="px-[24px] flex">
                            <div class="pr-3">
                                <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Years :</p>
                                <input type="number" value="5" id="interest_year" min="0" max="200" oninput="validity.valid||(value='');"
                                    class="mt-[16px] text-[#132813] outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                            </div>
                            <div class="pl-3">
                                <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Month :</p>
                                <input type="number" placeholder="0" id="interest_month" min="0" max="12" step="1" oninput="validity.valid||(value='');"
                                    class="mt-[16px] text-[#132813] outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                            </div>
                        </div>
                        <!---Line--->
                        <div class="px-[12px] mt-[30px]">
                            <hr class="">
                        </div>
                        <!--Additional contribution-->
                        <div class="px-[24px]">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Additional Contribution</p>
                                <p class="text-[#6C6C6C] pl-1">( Optional )</p>
                            </div>
                            <div class="flex mt-[16px] bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                <div onclick="changeContribution('none')" id="none" class="w-[90px] cursor-pointer text-[16px] rounded-l-[8px] text-[#132813] border-r border-[#132813]">
                                    <p class="flex justify-center items-center my-3">None</p>
                                </div>
                                <div onclick="changeContribution('deposits')" id="deposits" class="w-[90px] text-[#FFFFFF] cursor-pointer bg-[#132813] text-[16px] border-r border-[#132813]">
                                    <p class="flex justify-center items-center my-3">Deposits</p>
                                </div>
                                <div onclick="changeContribution('withdrawals')" id="withdrawals" class="w-[90px] cursor-pointer text-[16px] text-[#132813] border-r border-[#132813]">
                                    <p class="flex justify-center items-center my-3">Withdrawals</p>
                                </div>
                                <div onclick="changeContribution('both')" id="both" class="w-[90px] text-[16px] rounded-r-[8px] cursor-pointer text-[#132813]">
                                    <p class="flex justify-center items-center my-3">Both</p>
                                </div>
                            </div>
                        </div>
                        <!---Deposit amount-->
                        <div id="depositSection" class="px-[24px] contribution-section" style="display: none;">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Deposit amount</p>
                                <p class="text-[#6C6C6C] pl-1">( Optional )</p>
                            </div>
                            <div class="flex">
                                <div class="pr-3 w-6/12">
                                    <div class="flex">
                                        <input type="number"
                                            class="mt-[16px] text-[#132813] relative outline-none pl-[75px] pr-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <div class="w-[60px] absolute mt-[16px] text-[16px] border-r border-[#132813]">
                                            <p name="currency"
                                                class="flex justify-center text-[#132813] items-center my-3">$</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-3 w-6/12">
                                    <select id="deposit_period"
                                        class="mt-[16px] text-[#132813] outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <option value="">Daily</option>
                                        <option value="">Weekly</option>
                                        <option value="">Monthly</option>
                                        <option value="">Quarterly</option>
                                        <option value="">Yearly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!---Withdrawal amount-->
                        <div id="withdrawalSection" class="px-[24px] contribution-section" style="display: none;">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Withdrawal amount</p>
                                <p class="text-[#6C6C6C] pl-1">( Optional )</p>
                            </div>
                            <div class="flex">
                                <div class="pr-3 w-6/12">
                                    <div class="flex">
                                        <input type="number"
                                            class="mt-[16px] text-[#132813] relative outline-none pl-[75px] pr-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <div class="w-[60px] absolute mt-[16px] text-[16px] border-r border-[#132813]">
                                            <p name="currency"
                                                class="flex justify-center text-[#132813] items-center my-3">$</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-3 w-6/12">
                                    <select id="currencySelect"
                                        class="mt-[16px] text-[#132813] outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <optgroup label="Money Withdrawals">
                                        <option value="">monthly <p name="currency">$</p></option>
                                        <option value="">quarterly <p name="currency">$</p></option>
                                        <option value="">half-yearly <p name="currency">$</p></option>
                                        <option value="">yearly <p name="currency">$</p></option>
                                        </optgroup>
                                        <optgroup label="Percentage of Balance">
                                            <option value="">% each month</option>
                                            <option value="">% each year</option>
                                        </optgroup>
                                        <optgroup label="Earning Withdrawals">
                                            <option value="">% of earning monthly</option>
                                            <option value="">% of earning yearly</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!---Deposit period -->
                        <div id="depositPeriodSection" class="px-[24px] contribution-section" style="display: none;">
                            <p class="text-[#000000] pt-[28px] text-[16px] font-normal">Deposits made at what point in period?</p>
                            <div class="flex mt-[16px] bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                <div onclick="changeDepositPeriod('beginning')" id="beginning" class="cursor-pointer w-6/12 text-[16px] rounded-l-[8px] text-[#132813] border-r border-[#132813]">
                                    <p class="flex justify-center items-center my-3">Beginning</p>
                                </div>
                                <div onclick="changeDepositPeriod('end')" id="end" class="text-[#FFFFFF] w-6/12 cursor-pointer rounded-r-[8px] bg-[#132813] text-[16px]">
                                    <p class="flex justify-center items-center my-3">End</p>
                                </div>
                            </div>
                        </div>
                        <!---Annual Deposits-->
                        <div id="annualDepositSection" class="px-[24px] contribution-section" style="display: none;">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Annual Deposit % Increse?</p>
                                <p class="text-[#6C6C6C] pl-1">( Optional )</p>
                            </div>
                            <div class="w-6/12 flex pr-3">
                                <input type="number"
                                    class="mt-[16px] text-[#132813] relative outline-none pl-[15px] pr-[45px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                <div class="absolute -mt-2 left-[335px]">
                                    <p
                                        class="text-[16px] text-[#132813] flex justify-center items-center my-3 font-normal">
                                        %</p>
                                </div>
                            </div>
                        </div>
                        <!---Annual Withdrawal-->
                        <div id="annualWithdrawalSection" class="px-[24px] contribution-section" style="display: none;">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Annual Withdrawal % Increse?</p>
                                <p class="text-[#6C6C6C] pl-1">( Optional )</p>
                            </div>
                            <div class="w-6/12 flex pr-3">
                                <input type="number"
                                    class="mt-[16px] text-[#132813] relative outline-none pl-[15px] pr-[45px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                <div class="absolute -mt-2 left-[335px]">
                                    <p
                                        class="text-[16px] text-[#132813] flex justify-center items-center my-3 font-normal">
                                        %</p>
                                </div>
                            </div>
                        </div>
                        <!---Line--->
                        <div class="px-[12px] mt-[30px]">
                            <hr class="">
                        </div>
                        <!---Compound interval--->
                        <div class="px-[24px] pb-6">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Compound interval</p>
                            </div>
                            <div class="flex">
                                <div class="pr-3 w-6/12">
                                    <select id="compound_interval"
                                        class="mt-[16px] text-[#132813] outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <option value="daily-365">Daily (365/yr)</option>
                                        <option value="daily-360">Daily (360/yr)</option>
                                        <option value="weekly-140">Semi-Weekly (140/yr)</option>
                                        <option value="weekly-52">Weekly (52/yr)</option>
                                        <option value="weekly-26">Bi-Weekly (26/yr)</option>
                                        <option value="monthly-24">Semi-Monthly (24/yr)</option>
                                        <option value="monthly-12" selected>Monthly (12/yr)</option>
                                        <option value="monthly-6">Bi-Monthly (6/yr)</option>
                                        <option value="quarterly-4">Quarterly (4/yr)</option>
                                        <option value="yearly-2">Half-Yearly (2/yr)</option>
                                        <option value="yearly-1">Yearly (1/yr)</option>
                                    </select>
                                </div>
                                <div onclick="calculate()" class="pl-3 w-6/12 cursor-pointer">
                                    <div
                                        class="bg-[#132813] h-[50px] cursor-pointer mt-[16px] rounded-[8px] items-center flex">
                                        <svg class="ml-[19px]" width="18" height="20" viewBox="0 0 18 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.5 9.25H13.5C13.6989 9.25 13.8897 9.17098 14.0303 9.03033C14.171 8.88968 14.25 8.69891 14.25 8.5V4C14.25 3.80109 14.171 3.61032 14.0303 3.46967C13.8897 3.32902 13.6989 3.25 13.5 3.25H4.5C4.30109 3.25 4.11032 3.32902 3.96967 3.46967C3.82902 3.61032 3.75 3.80109 3.75 4V8.5C3.75 8.69891 3.82902 8.88968 3.96967 9.03033C4.11032 9.17098 4.30109 9.25 4.5 9.25ZM5.25 4.75H12.75V7.75H5.25V4.75ZM15.75 0.25H2.25C1.85218 0.25 1.47064 0.408035 1.18934 0.68934C0.908035 0.970644 0.75 1.35218 0.75 1.75V18.25C0.75 18.6478 0.908035 19.0294 1.18934 19.3107C1.47064 19.592 1.85218 19.75 2.25 19.75H15.75C16.1478 19.75 16.5294 19.592 16.8107 19.3107C17.092 19.0294 17.25 18.6478 17.25 18.25V1.75C17.25 1.35218 17.092 0.970644 16.8107 0.68934C16.5294 0.408035 16.1478 0.25 15.75 0.25ZM15.75 18.25H2.25V1.75H15.75V18.25ZM6.375 11.875C6.375 12.0975 6.30902 12.315 6.1854 12.5C6.06179 12.685 5.88609 12.8292 5.68052 12.9144C5.47495 12.9995 5.24875 13.0218 5.03052 12.9784C4.81229 12.935 4.61184 12.8278 4.4545 12.6705C4.29717 12.5132 4.19002 12.3127 4.14662 12.0945C4.10321 11.8762 4.12549 11.65 4.21064 11.4445C4.29578 11.2389 4.43998 11.0632 4.62498 10.9396C4.80999 10.816 5.0275 10.75 5.25 10.75C5.54837 10.75 5.83452 10.8685 6.0455 11.0795C6.25647 11.2905 6.375 11.5766 6.375 11.875ZM10.125 11.875C10.125 12.0975 10.059 12.315 9.9354 12.5C9.81179 12.685 9.63608 12.8292 9.43052 12.9144C9.22495 12.9995 8.99875 13.0218 8.78052 12.9784C8.56229 12.935 8.36184 12.8278 8.2045 12.6705C8.04717 12.5132 7.94002 12.3127 7.89662 12.0945C7.85321 11.8762 7.87549 11.65 7.96064 11.4445C8.04578 11.2389 8.18998 11.0632 8.37498 10.9396C8.55999 10.816 8.7775 10.75 9 10.75C9.29837 10.75 9.58452 10.8685 9.79549 11.0795C10.0065 11.2905 10.125 11.5766 10.125 11.875ZM13.875 11.875C13.875 12.0975 13.809 12.315 13.6854 12.5C13.5618 12.685 13.3861 12.8292 13.1805 12.9144C12.975 12.9995 12.7488 13.0218 12.5305 12.9784C12.3123 12.935 12.1118 12.8278 11.9545 12.6705C11.7972 12.5132 11.69 12.3127 11.6466 12.0945C11.6032 11.8762 11.6255 11.65 11.7106 11.4445C11.7958 11.2389 11.94 11.0632 12.125 10.9396C12.31 10.816 12.5275 10.75 12.75 10.75C13.0484 10.75 13.3345 10.8685 13.5455 11.0795C13.7565 11.2905 13.875 11.5766 13.875 11.875ZM6.375 15.625C6.375 15.8475 6.30902 16.065 6.1854 16.25C6.06179 16.435 5.88609 16.5792 5.68052 16.6644C5.47495 16.7495 5.24875 16.7718 5.03052 16.7284C4.81229 16.685 4.61184 16.5778 4.4545 16.4205C4.29717 16.2632 4.19002 16.0627 4.14662 15.8445C4.10321 15.6262 4.12549 15.4 4.21064 15.1945C4.29578 14.9889 4.43998 14.8132 4.62498 14.6896C4.80999 14.566 5.0275 14.5 5.25 14.5C5.54837 14.5 5.83452 14.6185 6.0455 14.8295C6.25647 15.0405 6.375 15.3266 6.375 15.625ZM10.125 15.625C10.125 15.8475 10.059 16.065 9.9354 16.25C9.81179 16.435 9.63608 16.5792 9.43052 16.6644C9.22495 16.7495 8.99875 16.7718 8.78052 16.7284C8.56229 16.685 8.36184 16.5778 8.2045 16.4205C8.04717 16.2632 7.94002 16.0627 7.89662 15.8445C7.85321 15.6262 7.87549 15.4 7.96064 15.1945C8.04578 14.9889 8.18998 14.8132 8.37498 14.6896C8.55999 14.566 8.7775 14.5 9 14.5C9.29837 14.5 9.58452 14.6185 9.79549 14.8295C10.0065 15.0405 10.125 15.3266 10.125 15.625ZM13.875 15.625C13.875 15.8475 13.809 16.065 13.6854 16.25C13.5618 16.435 13.3861 16.5792 13.1805 16.6644C12.975 16.7495 12.7488 16.7718 12.5305 16.7284C12.3123 16.685 12.1118 16.5778 11.9545 16.4205C11.7972 16.2632 11.69 16.0627 11.6466 15.8445C11.6032 15.6262 11.6255 15.4 11.7106 15.1945C11.7958 14.9889 11.94 14.8132 12.125 14.6896C12.31 14.566 12.5275 14.5 12.75 14.5C13.0484 14.5 13.3345 14.6185 13.5455 14.8295C13.7565 15.0405 13.875 15.3266 13.875 15.625Z"
                                                fill="#E1E1E1" />
                                        </svg>
                                        <p class="text-[16px] ml-[25px] text-[#FFFFFF] font-normal">Calculate</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--2nd col-->
            <div class="w-full md:w-7/12 pl-3 h-full pb-6">
                <div class="bg-[#F4F4F4] rounded-[8px]">
                    <div class="mt-0">
                        <div class="flex pt-6 pl-6 pr-[10px] text-[24px] font-medium leading-[29px] text-[#132815]">
                            <p class="">Interest Calculation For <span id="interest_year_value">5</span> Years
                            </p>
                            <div class="flex items-center ml-2">
                                <p id="interest_month_value"></p>
                            </div>
                        </div>
                        <!---Line--->
                        <div class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <div class="mt-[24px] pl-6 pr-[10px]">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-[16px] font-normal">
                                        <td class="w-5/12">Future investment value</td>
                                        <td class="w-1/12"></td>
                                        <td class="flex justify-start ml-7 text-left">Interest rate ( <span id="interest_period_value" class="px-1"> yearly </span> )</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-[28px] pt-4 text-[#61CE70EE] leading-[34px] font-bold">
                                            <div class="flex">
                                                <p class="currency mr-1">$</p>
                                                <p id="future_value">6,416.79</p>
                                            </div>
                                        </td>
                                        <td class="pt-4">
                                            <svg onclick="copyFutureValue()"  class="cursor-pointer" id="copy_future_value" width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M23.8438 0.125H7.34375C7.07025 0.125 6.80794 0.233649 6.61455 0.427046C6.42115 0.620443 6.3125 0.882746 6.3125 1.15625V6.3125H1.15625C0.882746 6.3125 0.620443 6.42115 0.427046 6.61455C0.233649 6.80794 0.125 7.07025 0.125 7.34375V23.8438C0.125 24.1173 0.233649 24.3796 0.427046 24.573C0.620443 24.7664 0.882746 24.875 1.15625 24.875H17.6562C17.9298 24.875 18.1921 24.7664 18.3855 24.573C18.5789 24.3796 18.6875 24.1173 18.6875 23.8438V18.6875H23.8438C24.1173 18.6875 24.3796 18.5789 24.573 18.3855C24.7664 18.1921 24.875 17.9298 24.875 17.6562V1.15625C24.875 0.882746 24.7664 0.620443 24.573 0.427046C24.3796 0.233649 24.1173 0.125 23.8438 0.125ZM16.625 22.8125H2.1875V8.375H16.625V22.8125ZM22.8125 16.625H18.6875V7.34375C18.6875 7.07025 18.5789 6.80794 18.3855 6.61455C18.1921 6.42115 17.9298 6.3125 17.6562 6.3125H8.375V2.1875H22.8125V16.625Z"
                                                    fill="#BEBEBE" />
                                            </svg>
                                        </td>
                                        <td class="pt-4 text-[28px] flex text-left justify-start ml-7 text-[#BEBEBE] leading-[34px] font-bold">
                                            <div class="flex items-center">
                                                <p id="interest_rate_value" class="">5</p>
                                                <p class="">%</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-[24px] pl-6 pr-[10px]">
                            <table class="-500 w-full">
                                <thead class="">
                                    <tr class="text-[16px] font-normal">
                                        <td class="w-5/12">Total interest earned</td>
                                        <td class="w-1/12"></td>
                                        <td class="flex justify-end text-left">All-time rate of Return ( RoR )</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td class="text-[28px] pt-4 text-[#BA924A] leading-[34px] font-bold">
                                            <div class="flex">
                                                <p class="currency pr-1">$</p>
                                                <p id="total_interest_earned">1,416.79</p>
                                            </div>
                                        </td>
                                        <td class="pt-4">
                                            <svg onclick="copyTotalInterest()" class="cursor-pointer" id="copy_total_interest" width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M23.8438 0.125H7.34375C7.07025 0.125 6.80794 0.233649 6.61455 0.427046C6.42115 0.620443 6.3125 0.882746 6.3125 1.15625V6.3125H1.15625C0.882746 6.3125 0.620443 6.42115 0.427046 6.61455C0.233649 6.80794 0.125 7.07025 0.125 7.34375V23.8438C0.125 24.1173 0.233649 24.3796 0.427046 24.573C0.620443 24.7664 0.882746 24.875 1.15625 24.875H17.6562C17.9298 24.875 18.1921 24.7664 18.3855 24.573C18.5789 24.3796 18.6875 24.1173 18.6875 23.8438V18.6875H23.8438C24.1173 18.6875 24.3796 18.5789 24.573 18.3855C24.7664 18.1921 24.875 17.9298 24.875 17.6562V1.15625C24.875 0.882746 24.7664 0.620443 24.573 0.427046C24.3796 0.233649 24.1173 0.125 23.8438 0.125ZM16.625 22.8125H2.1875V8.375H16.625V22.8125ZM22.8125 16.625H18.6875V7.34375C18.6875 7.07025 18.5789 6.80794 18.3855 6.61455C18.1921 6.42115 17.9298 6.3125 17.6562 6.3125H8.375V2.1875H22.8125V16.625Z"
                                                    fill="#BEBEBE" />
                                            </svg>
                                        </td>
                                        <td class="pt-4 felx justify-end text-left">
                                            <div class="flex items-center ml-7">
                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="13" cy="13" r="13" fill="#61CE70"
                                                        fill-opacity="0.933333" />
                                                    <path
                                                        d="M18.5 12.7708C18.4097 12.7713 18.3202 12.7536 18.2367 12.719C18.1533 12.6844 18.0776 12.6334 18.0142 12.5692L13 7.555L7.98584 12.5692C7.85551 12.6906 7.68313 12.7567 7.50502 12.7536C7.32691 12.7504 7.15698 12.6783 7.03101 12.5523C6.90505 12.4264 6.8329 12.2564 6.82976 12.0783C6.82662 11.9002 6.89273 11.7278 7.01417 11.5975L12.5142 6.0975C12.6431 5.96875 12.8178 5.89644 13 5.89644C13.1822 5.89644 13.3569 5.96875 13.4858 6.0975L18.9858 11.5975C19.1146 11.7264 19.1869 11.9011 19.1869 12.0833C19.1869 12.2655 19.1146 12.4403 18.9858 12.5692C18.9224 12.6334 18.8467 12.6844 18.7633 12.719C18.6798 12.7536 18.5903 12.7713 18.5 12.7708Z"
                                                        fill="white" />
                                                    <path
                                                        d="M13 20.1042C12.8184 20.1018 12.6449 20.0286 12.5165 19.9002C12.3881 19.7718 12.3149 19.5983 12.3125 19.4167V6.58333C12.3125 6.401 12.3849 6.22613 12.5139 6.0972C12.6428 5.96827 12.8177 5.89583 13 5.89583C13.1823 5.89583 13.3572 5.96827 13.4861 6.0972C13.6151 6.22613 13.6875 6.401 13.6875 6.58333V19.4167C13.6851 19.5983 13.6119 19.7718 13.4835 19.9002C13.3551 20.0286 13.1816 20.1018 13 20.1042Z"
                                                        fill="white" />
                                                </svg>
                                                <p class="pl-4 text-[28px] text-[#BEBEBE] leading-[34px] font-bold" id="ror">28.34%
                                                </p>
                                                <svg class="ml-6" width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.25" y="0.25" width="16.5" height="16.5" stroke="#B3B3B3"
                                                        stroke-width="0.5" />
                                                    <path
                                                        d="M7.664 10.216C7.664 8.44 9.668 8.104 9.668 6.904C9.668 6.232 9.092 5.776 8.168 5.776C7.28 5.776 6.632 6.112 6.212 6.7L5.048 5.944C5.72 5.032 6.8 4.48 8.3 4.48C10.064 4.48 11.24 5.284 11.24 6.664C11.24 8.62 9.188 8.8 9.188 10.216H7.664ZM8.432 13.084C7.868 13.084 7.472 12.664 7.472 12.148C7.472 11.632 7.868 11.224 8.432 11.224C8.984 11.224 9.38 11.632 9.38 12.148C9.38 12.664 8.984 13.084 8.432 13.084Z"
                                                        fill="#8E8E8E" />
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-4 px-6">
                            <p class="text-[16px]">Initial balance</p>
                            <div class="text-[28px] text-[#132815] font-bold">
                                <div class="flex">
                                    <p class="currency pr-1">$</p>
                                    <p id="initial_balance">5000.00</p>
                                </div>
                            </div>
                        </div>
                        <!---Line--->
                        <div class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <div class="mt-[24px] px-6">
                            <div class="flex">
                                <div class="pr-3">
                                    <p>Currency</p>
                                    <div class="flex mt-[16px] bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <div onclick="changePeriod('monthly')" id="monthly" class="w-[110px] cursor-pointer text-[16px] text-[#132813] rounded-l-[8px] border-r border-[#000000]">
                                            <p class="flex  justify-center items-center my-3">Monthly</p>
                                        </div>
                                        <div onclick="changePeriod('yearly')" id="yearly" class="w-[110px] cursor-pointer  bg-[#132813] text-[#FFFFFF] text-[16px] rounded-r-[8px]">
                                            <p class="flex justify-center items-center my-3">Yearly</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-3">
                                    <p class="text-[16px]">Table chart summery</p>
                                    <div
                                        class="flex items-center justify-between mt-[16px] px-[26px] bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <svg onclick="toggleTable()" class="cursor-pointer" id="table_svg" width="22" height="24" viewBox="0 0 22 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.40002 7.2H16.6M5.40002 13.6H7.00002M10.2 13.6H11.8M15 13.6H16.6M5.40002 18.4H7.00002M10.2 18.4H11.8M15 18.4H16.6M3.00002 23.2H19C19.4244 23.2 19.8313 23.0314 20.1314 22.7314C20.4315 22.4313 20.6 22.0243 20.6 21.6V2.4C20.6 1.97566 20.4315 1.56869 20.1314 1.26863C19.8313 0.968574 19.4244 0.800003 19 0.800003H3.00002C2.57568 0.800003 2.16871 0.968574 1.86865 1.26863C1.5686 1.56869 1.40002 1.97566 1.40002 2.4V21.6C1.40002 22.0243 1.5686 22.4313 1.86865 22.7314C2.16871 23.0314 2.57568 23.2 3.00002 23.2Z"
                                                stroke="#61CE70" stroke-opacity="0.933333" stroke-width="2" />
                                        </svg>
                                        <svg onclick="toggleChart()" class="cursor-pointer" id="chart_svg" width="20" height="18" viewBox="0 0 20 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14 8.78L18.24 1.45L19.97 2.45L14.74 11.5L8.23 7.75L3.46 16H20V18H0V0H2V14.54L7.5 5L14 8.78Z"
                                                fill="#B9B9B9" />
                                        </svg>
                                        <svg onclick="toggleSummary()" id="summary_svg" class="cursor-pointer" width="20" height="22" viewBox="0 0 20 22"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4 5C4 4.73478 4.10536 4.48043 4.29289 4.29289C4.48043 4.10536 4.73478 4 5 4H15C15.2652 4 15.5196 4.10536 15.7071 4.29289C15.8946 4.48043 16 4.73478 16 5C16 5.26522 15.8946 5.51957 15.7071 5.70711C15.5196 5.89464 15.2652 6 15 6H5C4.73478 6 4.48043 5.89464 4.29289 5.70711C4.10536 5.51957 4 5.26522 4 5ZM4 9C4 8.73478 4.10536 8.48043 4.29289 8.29289C4.48043 8.10536 4.73478 8 5 8H15C15.2652 8 15.5196 8.10536 15.7071 8.29289C15.8946 8.48043 16 8.73478 16 9C16 9.26522 15.8946 9.51957 15.7071 9.70711C15.5196 9.89464 15.2652 10 15 10H5C4.73478 10 4.48043 9.89464 4.29289 9.70711C4.10536 9.51957 4 9.26522 4 9ZM5 12C4.73478 12 4.48043 12.1054 4.29289 12.2929C4.10536 12.4804 4 12.7348 4 13C4 13.2652 4.10536 13.5196 4.29289 13.7071C4.48043 13.8946 4.73478 14 5 14H15C15.2652 14 15.5196 13.8946 15.7071 13.7071C15.8946 13.5196 16 13.2652 16 13C16 12.7348 15.8946 12.4804 15.7071 12.2929C15.5196 12.1054 15.2652 12 15 12H5ZM4 17C4 16.7348 4.10536 16.4804 4.29289 16.2929C4.48043 16.1054 4.73478 16 5 16H9C9.26522 16 9.51957 16.1054 9.70711 16.2929C9.89464 16.4804 10 16.7348 10 17C10 17.2652 9.89464 17.5196 9.70711 17.7071C9.51957 17.8946 9.26522 18 9 18H5C4.73478 18 4.48043 17.8946 4.29289 17.7071C4.10536 17.5196 4 17.2652 4 17Z"
                                                fill="#B9B9B9" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 3C0 2.20435 0.316071 1.44129 0.87868 0.87868C1.44129 0.31607 2.20435 0 3 0H17C17.7956 0 18.5587 0.31607 19.1213 0.87868C19.6839 1.44129 20 2.20435 20 3V19C20 19.7956 19.6839 20.5587 19.1213 21.1213C18.5587 21.6839 17.7956 22 17 22H3C2.20435 22 1.44129 21.6839 0.87868 21.1213C0.316071 20.5587 0 19.7956 0 19V3ZM3 2H17C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3V19C18 19.2652 17.8946 19.5196 17.7071 19.7071C17.5196 19.8946 17.2652 20 17 20H3C2.73478 20 2.48043 19.8946 2.29289 19.7071C2.10536 19.5196 2 19.2652 2 19V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2Z"
                                                fill="#B9B9B9" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!---Line--->
                         <div class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <!--Summary-->
                        <div class="mt-6 px-6" style="display: none;"  id="summary_container">
                            <p class="text-[#132813] text-[24px] mt-2 font-medium">Summary</p>
                            <div class="text-[16px] mt-4 flex text-left items-center">
                                <p class="font-bold w-4/12">Initial Deposit :</p>
                                <p id="summary_initial_deposit" class="font-medium ml-2">$5,000.00</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-bold w-4/12">Interest Rate :</p>
                                <p id="summary_interest_rate" class="font-medium ml-2">5%</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-bold w-4/12">Effective Rate :</p>
                                <p id="summary_effective_rate" class="font-medium ml-2">5.12%</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-bold w-4/12">Time :</p>
                                <p id="summary_time" class="font-medium ml-2">5 Years</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-bold w-4/12">Compounding :</p>
                                <p id="summary_compounding" class="font-medium ml-2">Monthly (12/yr)</p>
                            </div>
                        </div>
                         <!---Line--->
                         <div class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <!---Yearly Breakdown--->
                        <div id="breakdown">
                            <p class="pt-6 px-6 text-[#132813] text-[24px] font-medium"><span id="breakdown_option" class="pr-2">Yearly</span>Breakdown</p>
                        </div>
                        <div id="year_table">
                            <div id="table" class="pt-10 px-6 pb-[31px] relative h-[420px] overflow-y-scroll">
                                <table class="border-2 w-full">
                                    <thead class="h-[60px] sticky">
                                        <tr class="">
                                            <th id="tyear" class="bg-[#BA924A] w-[151px] text-center text-[#ffffff]">Year</th>
                                            <th style="display: none" id="tmonth" class="bg-[#BA924A] w-[151px] text-center text-[#ffffff]">Month</th>
                                            <th class="bg-[#BA924A] w-[151px] text-left pl-6 text-[#ffffff]">Interest</th>
                                            <th class="bg-[#132813] w-[151px] text-left pl-6 text-[#ffffff]">Accrued
                                                interest</th>
                                            <th class="bg-[#61CE70EE] w-[151px] text-left pl-6 text-[#ffffff]">balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            <td class="text-center">0</td>
                                            <td class="text-left pl-6">-</td>
                                            <td class="text-left pl-6">-</td>
                                            <td class="text-left pl-6">$5000.00</td>
                                        </tr>
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            <td class="text-center">1</td>
                                            <td class="text-left pl-6">$255.81</td>
                                            <td class="text-left pl-6">$255.81</td>
                                            <td class="text-left pl-6">$5255.81</td>
                                        </tr>
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            <td class="text-center">2</td>
                                            <td class="text-left pl-6">$268.90</td>
                                            <td class="text-left pl-6">$524.71</td>
                                            <td class="text-left pl-6">$5554.71</td>
                                        </tr>
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            <td class="text-center">3</td>
                                            <td class="text-left pl-6">$282.65</td>
                                            <td class="text-left pl-6">$807.36</td>
                                            <td class="text-left pl-6">$5807.36</td>
                                        </tr>
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            <td class="text-center">4</td>
                                            <td class="text-left pl-6">$297.12</td>
                                            <td class="text-left pl-6">$1104.48</td>
                                            <td class="text-left pl-6">$6104.48</td>
                                        </tr>
                                        <tr class="h-[45px] border-b text-[#ffffff] bg-[#132813]">
                                            <td class="text-center">5</td>
                                            <td class="text-left pl-6">$312.32</td>
                                            <td class="text-left pl-6">$1416.79</td>
                                            <td class="text-left pl-6">$6416.79</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                  
                        </div>
                        <!--Month table-->
                        <div id="month_table" style="display: none">
                            <div id="month_data_table" class="pt-10 px-6 pb-[31px] relative h-[420px] overflow-y-scroll">
                                <table class="border-2 w-full">
                                    <thead class="h-[60px] sticky">
                                        <tr class="">
                                            <th class="bg-[#BA924A] w-[151px] text-center text-[#ffffff]">Month</th>
                                            <th class="bg-[#BA924A] w-[151px] text-left pl-6 text-[#ffffff]">Interest</th>
                                            <th class="bg-[#132813] w-[151px] text-left pl-6 text-[#ffffff]">Accrued
                                                interest</th>
                                            <th class="bg-[#61CE70EE] w-[151px] text-left pl-6 text-[#ffffff]">balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="month_tbody">
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                  
                        </div>
                        <!--Chart-->
                        <div id="chart" style="display: none">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
// document.querySelector('input[type="number"]').addEventListener('keydown', function(event) {
//     if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
//         event.preventDefault();
//     }
// });

// // Get the element with the ID "alert-button"
// const alertButton = document.getElementById("alert");

// // Add a click event listener to the element
// alertButton.addEventListener("click", function() {
//   // Display the alert message
//   alert("Alert message!");
// });

function showAlert() {
    alert("Alert message!");
}
</script>