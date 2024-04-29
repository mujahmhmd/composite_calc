document.addEventListener('DOMContentLoaded', function() {
    console.log("Calculator Loaded Successfully");

    initializeCalculator();
    changeStyle("$");
});

function initializeCalculator() {
    // Get the calculate button
    const calculateButton = document.getElementById('calculate');
    const ror = document.getElementById('ror_svg');
    const summary = document.getElementById("summary_svg");
    // Add event listener to the calculate button
    calculateButton.addEventListener('click', function() {
        calculate();
    });
    ror.addEventListener('click', function() {
        toggleRor();
    });
    summary.addEventListener('click', function() {
        toggleSummary();
    });
}

// main calculate function
function calculate() {
    console.log("Calculating...");
    // Get the initial investment value from the input field
    let initial_investment = parseFloat(document.getElementById('initial_investment').value);
    let initial_balance = initial_investment.toFixed(2);
    let interest_rate = parseFloat(document.getElementById('interest_rate').value);
    let interest_period = document.getElementById('interest_period').value;
    let interest_year = parseFloat(document.getElementById('interest_year').value); 
    let interest_month = parseFloat(document.getElementById('interest_month').value);
    // let compound_interval = document.getElementById('compound_interval').value;
    var chart = document.getElementById("chart");

    var status = document.getElementById("status");
    var content = document.getElementById("content");

            // Show the status element and hide the content element
            status.style.display = "flex";
            content.style.display = "none";

            // Set a timeout to delay for 2 seconds
            setTimeout(function() {
                // Hide the status element
                status.style.display = "none";

                // Show the content element
                content.style.display = "block";
            }, 1000); // 2000 milliseconds = 1 seconds
    // Investment Details
    let investmentDetails = calculateInvestment(initial_balance, interest_rate, interest_period, interest_year, interest_month);
    
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
            <td class="text-center text-[16px] border-b-[0.5px]">${data.year}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${data.interest > 0 ? (selectedCurrency ? selectedCurrency : '$') + Number(data.interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${data.accruedInterest > 0 ? (selectedCurrency ? selectedCurrency : '$') + Number(data.accruedInterest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${selectedCurrency ? selectedCurrency : '$'}${Number(data.balance).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>

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
            <td class="text-center text-[16px] border-b-[0.5px]">${data.month}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${data.interest > 0 ? (selectedCurrency ? selectedCurrency : '$') + Number(data.interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${data.accruedInterest > 0 ? (selectedCurrency ? selectedCurrency : '$') + Number(data.accruedInterest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${selectedCurrency ? selectedCurrency : '$'}${Number(data.balance).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>

        `
        monthTable.appendChild(row);
    });



    // to Display value
    document.getElementById('interest_year_value').textContent = interest_month > 0 ? interest_year + ' ' +  (interest_year > 1 ? 'Years' : 'Year') + ' '  + interest_month + ' ' +  (interest_month > 1 ? 'Months' : 'Month') : interest_year + ' ' + (interest_year > 1 ? 'Years' : 'Year');
    // document.getElementById('interest_month_value').textContent = interest_month > 0 ? interest_month + ' ' +  (interest_month > 1 ? 'Months' : 'Month') : '';
    document.getElementById('interest_rate_value').textContent = interest_rate;
    document.getElementById('interest_period_value').textContent = '(' + ' ' + interest_period + ' ' + ')';
    document.getElementById('future_value').textContent = selectedCurrency ? selectedCurrency + investmentDetails.futureValue : '$'+investmentDetails.futureValue;
    document.getElementById('total_interest_earned').textContent = selectedCurrency ? selectedCurrency + investmentDetails.totalInterest : '$'+investmentDetails.totalInterest;
    document.getElementById('ror').textContent = investmentDetails.rateOfReturn;
    document.getElementById('initial_balance').textContent = selectedCurrency ? selectedCurrency + initial_balance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '$' + initial_balance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}).replace(/^(\d+)\.(\d+)$/, (_, integer, fraction) => integer.replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + fraction);


    // Summary Details
    switch (interest_period) {
    case 'Daily':
      int_period = 'Daily';
      break;
    case 'Weekly':
      int_period = 'Weekly';
      break;
    case 'Quarterly':
      int_period = 'Quarterly';
      break;
    case 'Monthly':
      int_period = 'Monthly';
      break;
    case 'Yearly':
      int_period = 'Yearly';
      break;
    default:
      // Handle invalid interval (optional)
      console.error("Invalid compound interval:", interest_period);
      break;
  }

  // Convert initial_balance to a formatted string with commas
  var initial_balance_float = parseFloat(initial_balance);
    //summary
   // Check if initial_balance_float is a valid number
    if (!isNaN(initial_balance_float)) {
        // Convert initial_balance to a formatted string with commas
        var formattedInitialBalance = numberWithCommas(initial_balance_float.toFixed(2));

        // Set the text content of the element using the formatted string
        document.getElementById('summary_initial_deposit').textContent = selectedCurrency ? selectedCurrency + formattedInitialBalance : '$' + formattedInitialBalance;
    } else {
        console.error('Initial balance is not a valid number:', initial_balance);
    }
    document.getElementById('summary_interest_rate').textContent = interest_rate + '%';
    document.getElementById('summary_effective_rate').textContent = investmentDetails.apy;
    document.getElementById('summary_time').textContent = interest_year + ' ' + (interest_year > 1 ? 'Years' : 'Year')+ ' ' + (interest_month > 0 ? interest_month + ' ' + (interest_month > 1 ? 'Months' : 'Month') : '');
    document.getElementById('summary_compounding').textContent = int_period;

    if(chart.style.display == "block"){
        toggleChart();
    }
    resetFutureValueIcon();
    resetTotalInterestIcon();

}

//Copy total interest
function copyTotalInterest() {
    // Get the copy icon element
    const copyIcon = document.getElementById("copy_total_interest");
    const copiedIcon = document.getElementById("copied_total_interest")
    // Get the future value element
    const totalInterestElement = document.getElementById("total_interest_earned");
    // Create a temporary textarea element to copy the text
    const tempTextarea = document.createElement("textarea");
    tempTextarea.value = totalInterestElement.innerText;
    document.body.appendChild(tempTextarea);
    // Select and copy the text
    tempTextarea.select();
    document.execCommand("copy");
    // Show the "copied" icon and hide the "copy" icon
    copiedIcon.style.display = "inline";
    copyIcon.style.display = "none";
    
}

// Function to reset the icons to their default state
function resetTotalInterestIcon() {
    const copyIcon = document.getElementById("copy_total_interest");
    const copiedIcon = document.getElementById("copied_total_interest");
    copiedIcon.style.display = "none"; // Hide the "copied" icon
    copyIcon.style.display = "inline"; // Show the "copy" icon
}

//copy future value
function copyFutureValue() {
    // Get the copy icon element
    const copyIcon = document.getElementById("copy_future_value");
    // Get the copied icon element
    const copiedIcon = document.getElementById("copied_future_value");
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
    // Show the "copied" icon and hide the "copy" icon
    copiedIcon.style.display = "inline";
    copyIcon.style.display = "none";
}

// Function to reset the icons to their default state
function resetFutureValueIcon() {
    const copyIcon = document.getElementById("copy_future_value");
    const copiedIcon = document.getElementById("copied_future_value");
    copiedIcon.style.display = "none"; // Hide the "copied" icon
    copyIcon.style.display = "inline"; // Show the "copy" icon
}
/**
 * Formats a number by adding commas as thousand separators.
 * @param {number|string} number - The number to be formatted.
 * @returns {string} - The formatted number with commas.
 */
function numberWithCommas(number) {
    // Convert the number to a string if necessary
    number = number.toString();
    
    // Use a regular expression to insert commas in the appropriate positions
    return number.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Function to toggle the visibility of ror_brief element
function toggleRor() {
    const rorBrief = document.getElementById("ror_brief");
    // Toggle the display style between "block" and "none"
    if (rorBrief.style.display === "none" || rorBrief.style.display === "") {
        rorBrief.style.display = "block"; // Show ror_brief
    } else {
        rorBrief.style.display = "none"; // Hide ror_brief
    }
}

//toggle Summary
function toggleSummary() {
    var summary = document.getElementById("summary_container");
    var summary_svg = document.getElementById("summary_svg");
    var summary_line = document.getElementById("summary_line");
    summary.style.display = summary.style.display === "none" ? "block" : "none";
    summary_svg.style.stroke = summary.style.display === "none" ? "#B9B9B9" : "#61CE70";
    summary_line.style.display = summary.style.display === "block" ? "block" : "none";
}

//change period
function changePeriod(period) {
    let breakdown = document.getElementById("breakdown_option");
    let yearTable = document.getElementById("year_table");
    let monthlyTable = document.getElementById("month_table");
    var chart_svg = document.getElementById("chart_svg");
    let chart = document.getElementById("chart");
    let monthTable = document.getElementById("month_tbody");


    // Get the initial investment value from the input field
    let initial_investment = parseFloat(document.getElementById('initial_investment').value);
    let initial_balance = initial_investment.toFixed(2);
    let interest_rate = parseFloat(document.getElementById('interest_rate').value);
    let interest_period = document.getElementById('interest_period').value;
    let interest_year = parseFloat(document.getElementById('interest_year').value); 
    let interest_month = parseFloat(document.getElementById('interest_month').value);
    // let compound_interval = document.getElementById('compound_interval').value;

    // Investment Details
    let investmentDetails = calculateInvestment(initial_balance, interest_rate, interest_period, interest_year, interest_month);


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
        monthlyTable.style.display = "block";
        if( monthTable.style.display === "none") {
            chart.style.display = "block";
        }
        if( chart.style.display === "none") {
            toggleTable(); 
        }
        if( chart.style.display === "block") {
            toggleChart();
        }
        
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
            <td class="text-center text-[16px] border-b-[0.5px]">${data.month}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${data.interest > 0 ? (selectedCurrency ? selectedCurrency : '$') + Number(data.interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${data.accruedInterest > 0 ? (selectedCurrency ? selectedCurrency : '$') + Number(data.accruedInterest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
            <td class="text-left text-[16px] border-b-[0.5px] pl-6">${selectedCurrency ? selectedCurrency : '$'}${Number(data.balance).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>

        `
        monthTable.appendChild(row);
    });
        
    } else if (year == period) {
        breakdown.textContent = "Yearly";
        yearTable.style.display = "block";
        monthlyTable.style.display = "none";
        if(yearTable.style.display === "none") {
            chart.style.display = "block";
        }
        if( chart.style.display === "none") {
            toggleTable();
            
        }
        if( chart.style.display === "block") {
            toggleChart();
        }
    } 
}

// toggle table
function toggleTable() {
    var breakdownOption = document.getElementById("breakdown_option");
    var selectedPeriod = breakdownOption.textContent.trim().toLowerCase();
    var table = document.getElementById("table");
    var monthlyTable = document.getElementById("month_data_table");
    var chart = document.getElementById("chart");
    var breakdown = document.getElementById("breakdown");
    var table_svg = document.getElementById("table_svg");
    var chart_svg = document.getElementById("chart_svg");

    
    if(selectedPeriod === "yearly"){
        table.style.display = "block";
        monthlyTable.style.display = "none";
    }else if(selectedPeriod === "monthly"){
        monthlyTable.style.display = "block";
        table.style.display = "none";
    }

    // table.style.display = "block";
    chart.style.display = "none";
    breakdown.style.display = "block";
    table_svg.style.stroke = "#61CE70";
    chart_svg.style.stroke = "#B9B9B9";
}

var myChart;
// toggle chart
function toggleChart() {
    // Check which period is selected by reading the text content of the breakdown_option element
    var breakdownOption = document.getElementById("breakdown_option");
    var selectedPeriod = breakdownOption.textContent.trim().toLowerCase();
    // Get the initial investment value from the input field
    let initial_investment = parseFloat(document.getElementById('initial_investment').value);
    let initial_balance = initial_investment.toFixed(2);
    let interest_rate = parseFloat(document.getElementById('interest_rate').value);
    let interest_period = document.getElementById('interest_period').value;
    let interest_year = parseFloat(document.getElementById('interest_year').value); 
    let interest_month = parseFloat(document.getElementById('interest_month').value);
    // let compound_interval = document.getElementById('compound_interval').value;

    let yearlyTableData = calculateInvestment(initial_balance, interest_rate, interest_period, interest_year, interest_month);
    // console.log("toggle data",yearlyTableData.tableData);

    // for years
    let years = [];
    yearlyTableData.tableData.forEach((element) => {
        if (element.year !== 0) {
            years.push(element.year);
        }
    });
    // console.log("Years:", years);

    let data = [];
    yearlyTableData.tableData.forEach((element) => {
            data.push(element.initial_investment);
            data.push(element.initial_investment);
        
        data.push(element.initial_investment);
        
    })
    // console.log("Data:", data);

    let balance = [];
    yearlyTableData.tableData.forEach((element) => {
        if(element.year !== 0) {
            balance.push(element.balance);
        }
    })
    // console.log("Balance:", balance);

    let accruedInterest = [];
    yearlyTableData.tableData.forEach((element, index) => {
        if(element.year !== 0) {
            accruedInterest.push(parseFloat(data[index]) + parseFloat(element.accruedInterest));
        }
    })
    // console.log("Accrued Interest:", accruedInterest);
    

    //for months
    let months = [];
    yearlyTableData.monthlyTableData.forEach((element) => {
        if(element.month !== 0) {
            months.push(element.month);
        }
    })

    let monthlyData = [];
    yearlyTableData.monthlyTableData.forEach((element) => {
        monthlyData.push(element.initial_investment);
    })

    let monthlyBalance = [];
    yearlyTableData.monthlyTableData.forEach((element) => {
        if(element.month !== 0) {
            monthlyBalance.push(element.balance);
        }
    })

    let monthlyAccruedInterest = [];
    yearlyTableData.monthlyTableData.forEach((element, index) => {
        if(element.month !== 0) {
            monthlyAccruedInterest.push(parseFloat(monthlyData[index]) + parseFloat(element.accruedInterest));
        }
    })


    // Check if a chart instance already exists
    if (myChart) {
        // If a chart instance exists, destroy it
        myChart.destroy();
    }
    var ctx = document.getElementById('myChart').getContext('2d');

    if(selectedPeriod === "yearly") {
    // Create a new chart instance
        // Now, you can create a new chart instance on the canvas
        myChart = new Chart(ctx, {
        data: {
            datasets: [{
                type: 'bar',
                label: 'Initial Investment',
                data: data,
                backgroundColor: '#66B2FF', // First dataset color
                barPercentage: 0.8, // Set barPercentage less than 1 to overlap bars
                order: 1
            }, {
                type: 'bar',
                label: 'Accrued Interest',
                data: accruedInterest,
                backgroundColor: '#132813', // Second dataset color
                barPercentage: 0.8, // Set barPercentage less than 1 to overlap bars
                categoryPercentage: 0.8,
                order: 2
            },
            {
                type: 'line',
                label: 'Balance',
                borderColor: '#61CE70',
                fill: '#61CE70EE',
                data: balance,
            }
        ],
            labels: years
        },
        options:{
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var datasetLabel = context.dataset.label || '';
                                var value = context.parsed.y;
                                var label = '';
                                if (datasetLabel === 'Initial Investment') {
                                    label = 'Initial Investment: ' + (selectedCurrency ? selectedCurrency + numberWithCommas(value.toFixed(2)) : '$' + numberWithCommas(value.toFixed(2)));
                                } else if (datasetLabel === 'Accrued Interest') {
                                    var index = context.dataIndex;
                                    var initialInvestment = data[index];
                                    var balanceValue = balance[index];
                                    var difference = accruedInterest[index] - initialInvestment;
                                    label = 'Accrued Interest: ' + (selectedCurrency ? selectedCurrency + numberWithCommas(difference.toFixed(2)) : '$' + numberWithCommas(difference.toFixed(2)));
                                } else if (datasetLabel === 'Balance') {
                                    label = 'Balance: ' + (selectedCurrency ? selectedCurrency + numberWithCommas(value.toFixed(2)) : '$' + numberWithCommas(value.toFixed(2)));
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
    else if (selectedPeriod === "monthly") {
    // Now, you can create a new chart instance on the canvas
    myChart = new Chart(ctx, {
    data: {
        datasets: [{
            type: 'bar',
            label: 'Initial Investment',
            data: monthlyData,
            backgroundColor: '#66B2FF', // First dataset color
            barPercentage: 0.8, // Set barPercentage less than 1 to overlap bars
            order: 1
        }, {
            type: 'bar',
            label: 'Accrued Interest',
            data: monthlyAccruedInterest,
            backgroundColor: '#132813', // Second dataset color
            barPercentage: 0.8, // Set barPercentage less than 1 to overlap bars
            categoryPercentage: 0.8,
            order: 2
        },
        {
            type: 'line',
            label: 'Balance',
            borderColor: '#61CE70',
            fill: '#61CE70EE',
            data: monthlyBalance,
        }
    ],
        labels: months
    },
    options:{
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var datasetLabel = context.dataset.label || '';
                                var value = context.parsed.y;
                                var label = '';
                                if (datasetLabel === 'Initial Investment') {
                                    label = 'Initial Investment: ' + (selectedCurrency ? selectedCurrency + numberWithCommas(value.toFixed(2)) : '$' + numberWithCommas(value.toFixed(2)));
                                } else if (datasetLabel === 'Accrued Interest') {
                                    var index = context.dataIndex;
                                    var initialInvestment = monthlyData[index];
                                    var balanceValue = monthlyBalance[index];
                                    var difference = monthlyAccruedInterest[index] - initialInvestment;
                                    label = 'Accrued Interest: ' + (selectedCurrency ? selectedCurrency + numberWithCommas(difference.toFixed(2)) : '$' + numberWithCommas(difference.toFixed(2)));
                                } else if (datasetLabel === 'Balance') {
                                    label = 'Balance: ' + (selectedCurrency ? selectedCurrency + numberWithCommas(value.toFixed(2)) : '$' + numberWithCommas(value.toFixed(2)));
                                }
                                return label;
                            }
                        }
                    }
                }
        }
    });
}
    
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

var selectedCurrency;
// Change style function (Currency)
function changeStyle(currency) {
    // console.log("change style functions is working.. (Currency)")
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
    selectedCurrency = currency;
}

// Calculation for investment Details
function calculateInvestment(initial_investment, interest_rate, interest_period, interest_year, interest_month) {
    // let compound_interval = document.getElementById('compound_interval').value;
    let int_period = document.getElementById('interest_period').value;
    let compound_int;
    let numberOfPeriods;
    let tableMonths;
    let monthlyTableInterestRate;
    let periods;
    interest_month > 0 ? interest_month = parseInt(interest_month) : interest_month = 0

    // Calculate total number of months based on user input of years and months
    let totalMonths = parseInt(interest_year) * 12 + parseInt(interest_month);
    // console.log("total moths", totalMonths)


    // Convert annual interest rate to decimal and monthly interest rate
    let effectiveRate = interest_rate / 100;
    // console.log("effective rate", effectiveRate, "type of", typeof(effectiveRate))

    switch(int_period) {
        case 'Yearly':
            numberOfPeriods = interest_month ? parseInt(interest_year) + interest_month / 12 : parseInt(interest_year);
            // console.log("case number of period", numberOfPeriods)
            compound_int = 1;
            tableMonths = interest_month / 12;
            monthlyTableInterestRate = effectiveRate / compound_int / 12;
            // console.log("Case monthlyTableInterestRate", monthlyTableInterestRate)
            periods = 12;
            break;
        case 'Quarterly':
            numberOfPeriods = interest_month ?  parseInt(interest_year) * 4 + interest_month / 12 * 4 : parseInt(interest_year) * 4;
            // console.log("case number of period", numberOfPeriods)
            compound_int = 4;
            tableMonths = interest_month / 12 * 4;
            monthlyTableInterestRate = effectiveRate / compound_int / 12 * 4;
            periods = 3;
            break;
        case 'Monthly':
            numberOfPeriods = totalMonths;
            // console.log("case number of period", numberOfPeriods)
            compound_int = 12;
            tableMonths = interest_month;
            monthlyTableInterestRate = effectiveRate / compound_int;
            periods = 1;
            break;
        case 'Weekly':
            numberOfPeriods = interest_month ? parseInt(interest_year) * 52 + interest_month / 12 * 52 : parseInt(interest_year) * 52;
            // console.log("case number of period", numberOfPeriods)
            compound_int = 52;
            tableMonths = interest_month / 12 * 52;
            // console.log("CASE of EXTRA", effectiveRate / compound_int)
            monthlyTableInterestRate = Math.pow((1 + effectiveRate / compound_int), compound_int * 1 / 12) - 1
            // console.log("Case OF Table Monthly Interest Rate", monthlyTableInterestRate.toFixed(9));
            periods = 1;
            break;
        case 'Daily':
            numberOfPeriods = interest_month ? parseInt(interest_year) * 365 + interest_month / 12 * 365 : parseInt(interest_year) * 365;
            // console.log("case number of period", numberOfPeriods)
            compound_int = 365;
            tableMonths = interest_month / 12 * 365;
            monthlyTableInterestRate = Math.pow((1 + effectiveRate / compound_int), compound_int * 1 / 12) - 1;
            // console.log("Case OF Table Monthly Interest Rate", monthlyTableInterestRate);
            periods = 1;
            break;
    }

    // Handle different combinations of interest period and compound interval
    // switch (int_period) {
    //     case 'Yearly':
    //         switch (compound_interval) {
    //             case 'monthly-12':
    //                 numberOfPeriods = totalMonths;
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 12;
    //                 tableMonths = interest_month;
    //                 monthlyTableInterestRate = effectiveRate / compound_int;
    //                 periods = 1;
    //                 break;
    //             case 'yearly-1':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) + interest_month / 12 : parseInt(interest_year);
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 1;
    //                 tableMonths = interest_month / 12;
    //                 monthlyTableInterestRate = effectiveRate / compound_int / 12;
    //                 console.log("Case monthlyTableInterestRate", monthlyTableInterestRate)
    //                 periods = 12;
    //                 break;
    //             case 'yearly-2':
    //                 numberOfPeriods = interest_month ?  parseInt(interest_year) * 2 + interest_month / 12 * 2 : parseInt(interest_year) * 2;
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 2;
    //                 tableMonths = interest_month / 12 * 2;
    //                 monthlyTableInterestRate = effectiveRate / compound_int / 12 * 2;
    //                 periods = 6;
    //                 break;
    //             case 'quarterly-4':
    //                 numberOfPeriods = interest_month ?  parseInt(interest_year) * 4 + interest_month / 12 * 4 : parseInt(interest_year) * 4;
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 4;
    //                 tableMonths = interest_month / 12 * 4;
    //                 monthlyTableInterestRate = effectiveRate / compound_int / 12 * 4;
    //                 periods = 3;
    //                 break;
    //             case 'monthly-6':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 6 + interest_month / 12 * 6 : parseInt(interest_year) * 12 / 2; // 2 times per year
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 6;
    //                 tableMonths = interest_month / 12 * 6;
    //                 monthlyTableInterestRate = (effectiveRate / compound_int) / 12 * 6;
    //                 periods = 2;
    //                 break;
    //             case 'monthly-24':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 24 + interest_month / 12 * 24 : parseInt(interest_year) * 12 / 0.5; // 0.5 times per year
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 24;
    //                 tableMonths = interest_month / 12 * 24;
    //                 monthlyTableInterestRate = (effectiveRate / compound_int) / 12 * 24;
    //                 console.log("Case monthlyTableInterestRate", monthlyTableInterestRate)
    //                 periods = 0.5;
    //                 break;
    //             case 'weekly-26':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 26 + interest_month / 12 * 26 : parseInt(interest_year) * 52 / 2; // 2 times per year
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 26;
    //                 tableMonths = interest_month / 12 * 26;
    //                 monthlyTableInterestRate = (effectiveRate / compound_int) / 12 * 26;
    //                 periods = 0.5;
    //                 break;
    //             case 'weekly-52':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 52 + interest_month / 12 * 52 : parseInt(interest_year) * 52;
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 52;
    //                 tableMonths = interest_month / 12 * 52;
    //                 monthlyTableInterestRate = effectiveRate / compound_int / 12 * 52;
    //                 periods = 1;
    //                 break;
    //             case 'weekly-104':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 104 / 52 + interest_month / 12 * 104 / 52 : parseInt(interest_year) * 104; // 104 weeks in a year  Doubt
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 104;
    //                 tableMonths = interest_month / 12 * 104;
    //                 monthlyTableInterestRate = effectiveRate / compound_int / 12 * 104;
    //                 periods = 1;
    //                 break;
    //             case 'daily-360':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 360  + interest_month / 12 * 360 : parseInt(interest_year) * 360;
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 360;
    //                 tableMonths = interest_month / 12 * 360;
    //                 monthlyInterestRate = effectiveRate / compound_int / 12 * 360;
    //                 periods = 1;
    //                 break;
    //             case 'daily-365':
    //                 numberOfPeriods = interest_month ? parseInt(interest_year) * 365 + interest_month / 12 * 365 : parseInt(interest_year) * 365;
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 365;
    //                 tableMonths = interest_month / 12 * 365;
    //                 monthlyTableInterestRate = effectiveRate / compound_int / 12 * 365;
    //                 periods = 1;
    //                 break;
    //             default:
    //                 console.error("Invalid combination of interest period and compound interval");
    //                 break;
    //         }
    //         break;
    //     case 'Monthly':
    //         switch (compound_interval) {
    //             case 'monthly-6':
    //                 numberOfPeriods = totalMonths * 2; // Compounded every two months
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 6;
    //                 break;
    //             case 'monthly-12':
    //                 numberOfPeriods = totalMonths * 12; // Compounded every month
    //                 console.log("case number of period", numberOfPeriods)
    //                 compound_int = 12;
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'monthly-24':
    //                 numberOfPeriods = totalMonths / 0.5; // Compounded every 0.5 month (every two months)
    //                 compound_int = 24;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'yearly-1':
    //                 numberOfPeriods = parseInt(interest_year) / 12; // Compounded yearly
    //                 compound_int = 12;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'yearly-2':
    //                 numberOfPeriods = parseInt(interest_year) / 6; // Compounded semi-annually
    //                 compound_int = 6;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'quarterly-4':
    //                 numberOfPeriods = parseInt(interest_year) / 3; // Compounded quarterly
    //                 compound_int = 3;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'weekly-26':
    //                 numberOfPeriods = parseInt(interest_year) * 52 / 24; // Compounded every two weeks
    //                 compound_int = 2;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'weekly-52':
    //                 numberOfPeriods = parseInt(interest_year) * 52 / 12; // Compounded weekly
    //                 compound_int = 1;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'weekly-104':
    //                 numberOfPeriods = parseInt(interest_year) * 104 / 12 / 2; // Compounded semi-weekly (with 140 weeks in a year)
    //                 compound_int = 0.5;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'daily-360':
    //                 numberOfPeriods = parseInt(interest_year) * 360 / 12; // Compounded daily (assuming 360 days in a year)
    //                 compound_int = 30;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             case 'daily-365':
    //                 numberOfPeriods = parseInt(interest_year) * 365 / 12; // Compounded daily (assuming 365 days in a year)
    //                 compound_int = 30.42;
    //                 console.log("case number of period", numberOfPeriods)
    //                 console.log("Case OF Compound Int", compound_int)
    //                 break;
    //             default:
    //                 console.error("Invalid combination of interest period and compound interval");
    //                 break;
    //         }
    //         break;
    //     case 'Quarterly':
    //         switch (compound_interval) {
    //         case 'monthly-6':
    //             numberOfPeriods = parseInt(interest_year) * 2 * 4; // Compounded every two months, accounting for 4 quarters per year
    //             compound_int = 1.5;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'monthly-12':
    //             numberOfPeriods = parseInt(interest_year) * 4; // Compounded every month, accounting for 4 quarters per year
    //             console.log("selected", numberOfPeriods)
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             compound_int = 3;
    //             break;
    //         case 'monthly-24':
    //             numberOfPeriods = parseInt(interest_year) * 2; // Compounded every 0.5 month (every two months), accounting for 4 quarters per year
    //             compound_int = 1.5;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'yearly-1':
    //             numberOfPeriods = parseInt(interest_year); // Compounded yearly
    //             compound_int = 1;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'yearly-2':
    //             numberOfPeriods = parseInt(interest_year) / 2; // Compounded semi-annually
    //             compound_int = 0.5;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'quarterly-4':
    //             numberOfPeriods = parseInt(interest_year); // Compounded quarterly
    //             compound_int = 1;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-26':
    //             numberOfPeriods = parseInt(interest_year) * 52 / 4; // Compounded every two weeks, accounting for 4 quarters per year
    //             compound_int = 0.5;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-52':
    //             numberOfPeriods = parseInt(interest_year) * 52 / 4; // Compounded weekly, accounting for 4 quarters per year
    //             compound_int = 0.25;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-104':
    //             numberOfPeriods = parseInt(interest_year) * 104 / 4 / 2; // Compounded semi-weekly (with 140 weeks in a year), accounting for 4 quarters per year
    //             compound_int = 0.125;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'daily-360':
    //             numberOfPeriods = parseInt(interest_year) * 360 / 4; // Compounded daily (assuming 360 days in a year), accounting for 4 quarters per year
    //             compound_int = 30 / 4;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'daily-365':
    //             numberOfPeriods = parseInt(interest_year) * 365 / 4; // Compounded daily (assuming 365 days in a year), accounting for 4 quarters per year
    //             compound_int = 365 / 4;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         default:
    //             console.error("Invalid combination of interest period and compound interval");
    //             break;
    //     }
    //         break;
    //     case 'Weekly':
    //         switch (compound_interval) {
    //         case 'monthly-6':
    //             numberOfPeriods = parseInt(interest_year) * 2 * 6; // Compounded every two months, accounting for 4 weeks per month and 6 months per year
    //             compound_int = 2;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'monthly-12':
    //             numberOfPeriods = parseInt(interest_year) * 12; // Compounded every month, accounting for 4 weeks per month and 12 months per year
    //             compound_int = 4;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'monthly-24':
    //             numberOfPeriods = parseInt(interest_year) * 24 / 2; // Compounded every 0.5 month (every two months), accounting for 4 weeks per month and 6 months per year
    //             compound_int = 2;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'yearly-1':
    //             numberOfPeriods = parseInt(interest_year) * 52; // Compounded yearly, assuming 52 weeks in a year
    //             compound_int = 52;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'yearly-2':
    //             numberOfPeriods = parseInt(interest_year) * 52 * 2; // Compounded semi-annually, assuming 52 weeks in a year
    //             compound_int = 52 * 2;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'quarterly-4':
    //             numberOfPeriods = parseInt(interest_year) * 52 / 4; // Compounded quarterly, assuming 52 weeks in a year
    //             compound_int = 13;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-26':
    //             numberOfPeriods = parseInt(interest_year) * 26; // Compounded every two weeks, assuming 26 bi-weekly periods in a year
    //             compound_int = 2;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-52':
    //             numberOfPeriods = parseInt(interest_year) * 52; // Compounded weekly, assuming 52 weeks in a year
    //             compound_int = 1;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-140':
    //             numberOfPeriods = parseInt(interest_year) * 140; // Compounded semi-weekly (with 140 weeks in a year), assuming 140 weeks in a year
    //             compound_int = 140;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'daily-360':
    //             numberOfPeriods = parseInt(interest_year) * 360 / 7; // Compounded daily (assuming 360 days in a year), accounting for 7 days in a week
    //             compound_int = 360 / 7;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'daily-365':
    //             numberOfPeriods = parseInt(interest_year) * 365 / 7; // Compounded daily (assuming 365 days in a year), accounting for 7 days in a week
    //             compound_int = 365 / 7;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         default:
    //             console.error("Invalid combination of interest period and compound interval");
    //             break;
    //     }
    //         break;
    //     case 'Daily':
    //         switch (compound_interval) {
    //         case 'monthly-6':
    //             numberOfPeriods = parseInt(interest_year) * 2 * 30 / 7; // Compounded every two months, assuming 30 days per month and 7 days in a week
    //             compound_int = 6 * 30;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'monthly-12':
    //             numberOfPeriods = parseInt(interest_year) * 30 / 7; // Compounded every month, assuming 30 days per month and 7 days in a week
    //             compound_int = 12 * 30;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'monthly-24':
    //             numberOfPeriods = parseInt(interest_year) * 30 / 7 / 2; // Compounded every 0.5 month (every two months), assuming 30 days per month and 7 days in a week
    //             compound_int = 24 * 15;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'yearly-1':
    //             numberOfPeriods = parseInt(interest_year) * 365 / 7; // Compounded yearly, assuming 365 days in a year and 7 days in a week
    //             compound_int = 365;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'yearly-2':
    //             numberOfPeriods = parseInt(interest_year) * 365 * 2 / 7; // Compounded semi-annually, assuming 365 days in a year and 7 days in a week
    //             compound_int = 365 * 2;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'quarterly-4':
    //             numberOfPeriods = parseInt(interest_year) * 365 / 4 / 7; // Compounded quarterly, assuming 365 days in a year and 7 days in a week
    //             compound_int = 365 / 4;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-26':
    //             numberOfPeriods = parseInt(interest_year) * 26; // Compounded every two weeks, assuming 26 bi-weekly periods in a year
    //             compound_int = 26 * 7;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-52':
    //             numberOfPeriods = parseInt(interest_year) * 52; // Compounded weekly, assuming 52 weeks in a year
    //             compound_int = 52 * 7;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'weekly-140':
    //             numberOfPeriods = parseInt(interest_year) * 140; // Compounded semi-weekly (with 140 weeks in a year), assuming 140 weeks in a year
    //             compound_int = 140 * 7;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'daily-360':
    //             numberOfPeriods = parseInt(interest_year) * 360; // Compounded daily (assuming 360 days in a year)
    //             compound_int = 360;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         case 'daily-365':
    //             numberOfPeriods = parseInt(interest_year) * 365; // Compounded daily (assuming 365 days in a year)
    //             compound_int = 365;
    //             console.log("case number of period", numberOfPeriods)
    //             console.log("Case OF Compound Int", compound_int)
    //             break;
    //         default:
    //             console.error("Invalid combination of interest period and compound interval");
    //             break;
    //     }
    //         break;
    //     default:
    //         console.error("Invalid combination of interest period and compound interval");
    //         break;
    // }

    // console.log("number of periods", numberOfPeriods);

    // let monthlyInterestRate = Math.pow(1 + effectiveRate / compound_int, compound_int) - 1;
    
    let monthlyInterestRate = effectiveRate / compound_int;
    // console.log("compound_int", compound_int, "type of", typeof(compound_int))
    // console.log("monthly interest rate", monthlyInterestRate, "type of", typeof(monthlyInterestRate))

    // Calculate total number of compounding periods
    // let numberOfPeriods = totalMonths * compound_int; no need
    
    // Calculate Compound Amount
    // let compoundAmount = initial_investment * Math.pow(1 + monthlyInterestRate / compound_int , compound_int * numberOfPeriods); no need
    let compoundAmount = initial_investment * Math.pow(1 + monthlyInterestRate, numberOfPeriods);
    // console.log("compound amount", compoundAmount)

    // Calculate total interest earned
    let totalInterest = compoundAmount - initial_investment;
    // console.log("total interest", totalInterest)

    // Calculate all-time rate of return (RoR)
    // let rateOfReturn = ((compoundAmount - initial_investment) / initial_investment) * 100; no need
    let rateOfReturn = (totalInterest / initial_investment) * 100;
    // console.log("rate of return", rateOfReturn)

    // Calculate APY
    let apy = Math.pow(1 + effectiveRate / compound_int, compound_int) - 1;
    apy *= 100; // convert to percentage
    // console.log("apy", apy)


    // Prepare data for yearly table rows
    let tableData = [];
    let currentBalance = parseFloat(initial_investment);
    let accruedInterest = 0;
    let forMonth;
    // Row for initial investment details
    tableData.push({
        year: 0,
        interest: '-',
        accruedInterest: '-',
        balance: parseFloat(initial_investment),
        initial_investment: initial_investment
    });
    
    let year = parseInt(interest_year);
    year = parseInt(interest_month) > 0 ? year + 1 : year;
    // Rows for each interest year starting from the second year
    for (let i = 1; i <= year; i++) {
    let monthsInYear = compound_int; // Total months in a year
    if (i === year && interest_month > 0) {
        monthsInYear = tableMonths; // Update months for the last year
        // console.log("moths year in inside (tableMonths)", monthsInYear)
    }
    // let months = (i - 1) * 12 + monthsInYear; // Calculate total months up to this year
    // console.log("Total months for year", i, ":", months);
    let compound_amnt = currentBalance * Math.pow(1 + monthlyInterestRate, monthsInYear); // number of periods / year
    // console.log("table compound amount", compound_amnt)
    forMonth = compound_amnt;
    let interestEarned = (compound_amnt - currentBalance); // Keeping as a number
    // console.log("interest earned", interestEarned)
    accruedInterest += parseFloat(interestEarned);
    currentBalance = parseFloat(currentBalance + interestEarned); // Keeping as a number

    tableData.push({
        year: i,
        interest: interestEarned,
        accruedInterest: accruedInterest.toFixed(2),
        balance: currentBalance,
        initial_investment: initial_investment
    });
}

    // console.log("tableData", tableData)

    // monthly interest table
    let monthlyTableData = [];
    let monthlyAccruedInterest = 0;
    let monthlyCurrentBalance = parseFloat(initial_investment);

    monthlyTableData.push({
        month: 0,
        interest: '-',
        accruedInterest: '-',
        balance: parseFloat(initial_investment),
        initial_investment: initial_investment
    });

    let monthlyInterestEarned;

    // Rows for each month
    for (let i = 1; i <= totalMonths; i++) {  
        if((i - 1 ) % periods === 0) {
            monthlyInterestEarned = monthlyCurrentBalance * monthlyTableInterestRate;
            // console.log("Monthly Interest Earned inside the if", monthlyInterestEarned)
        }
    
        monthlyAccruedInterest += parseFloat(monthlyInterestEarned);
        monthlyCurrentBalance = (parseFloat(monthlyCurrentBalance) + parseFloat(monthlyInterestEarned));

        monthlyTableData.push({
            month: i,
            interest: monthlyInterestEarned,
            accruedInterest: monthlyAccruedInterest.toFixed(2),
            balance: monthlyCurrentBalance,
            initial_investment: initial_investment
        });
        
    }

    // console.log("monthly interest table", monthlyTableData)
    return {
        futureValue: compoundAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}), // Format with thousands separators and two decimal places
        totalInterest: totalInterest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}), // Format with thousands separators and two decimal places
        rateOfReturn: rateOfReturn.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + "%", // Rounded to 2 decimal places and formatted as percentage
        apy: apy.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + "%", // APY formatted as percentage
        tableData: tableData,
        monthlyTableData: monthlyTableData
    };

}

// Add an event listener for when the DOM content is fully loaded
// document.addEventListener("DOMContentLoaded", function() {
//     // Initially display the deposit amount and annual deposit sections
//     document.getElementById("depositSection").style.display = "block";
//     document.getElementById("annualDepositSection").style.display = "block";
// });

// function changeContribution(contribution) {
//     // Reset all elements to default style
//     let contributions = ["none", "deposits", "withdrawals", "both"];
//     contributions.forEach(function(cont) {
//         let element = document.getElementById(cont);
//         if (element) {
//             element.style.backgroundColor = '#EBEBEB';
//             element.style.color = '#132813';
//         }
//     });

//     // Hide all sections
//     let sections = document.querySelectorAll(".contribution-section");
//     sections.forEach(function(section) {
//         section.style.display = "none";
//     });

//     // Highlight selected contribution
//     let selectedElement = document.getElementById(contribution);
//     if (selectedElement) {
//         selectedElement.style.backgroundColor = '#132813';
//         selectedElement.style.color = '#ffffff';
//     }

//     // Show relevant sections based on contribution type
//     switch(contribution) {
//         case "deposits":
//             document.getElementById("depositSection").style.display = "block";
//             document.getElementById("depositPeriodSection").style.display = "block";
//             document.getElementById("annualDepositSection").style.display = "block";
//             break;
//         case "withdrawals":
//             document.getElementById("withdrawalSection").style.display = "block";
//             document.getElementById("annualWithdrawalSection").style.display = "block";
//             break;
//         case "both":
//             document.getElementById("depositSection").style.display = "block";
//             document.getElementById("depositPeriodSection").style.display = "block";
//             document.getElementById("annualDepositSection").style.display = "block";
//             document.getElementById("withdrawalSection").style.display = "block";
//             document.getElementById("annualWithdrawalSection").style.display = "block";
//             break;
//         default:
//             // No action needed for "none"
//             break;
//     }


// }


// function changeDepositPeriod(deposit_period) {
//     // Reset all elements to default style\
//     let deposit_periods = ["beginning", "end"];
//     deposit_periods.forEach(function(deposit) {
//         let element = document.getElementById(deposit);
//         if (element) {
//             element.style.backgroundColor = '#EBEBEB';
//             element.style.color = '#132813';
//         }
//     })

//     let selectedElement = document.getElementById(deposit_period);
//     if (selectedElement) {
//         selectedElement.style.backgroundColor = '#132813';
//         selectedElement.style.color = '#ffffff';
//     }
// }


// var com_int = document.getElementById("compound_interval");
// if(com_int) {
//     com_int.addEventListener("change", function() {
//         updateInterestPeriod();
//     })
// }
// // Add event listener to compound interval select box
// document.getElementById('compound_interval').addEventListener('change', updateInterestPeriod);

// var dep_period = document.getElementById("deposit_period");
// if(dep_period) {
//     dep_period.addEventListener("change", function() {
//         updateCompoundInterval();
//     })
// }
// Add event listener to interest period select box
// document.getElementById('deposit_period').addEventListener('change', updateCompoundInterval);