<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"> -->
    <title>Document</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body{
            font-family: 'Montserrat', sans-serif;
        }

        /* Hide the number spinner */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
       
        table { border: none;  }
        table th{ height: 60px; position: sticky; top: -1px; z-index: 999; border-left: 2px solid #E5E5E5; }
        table td,th:first-child { border-left: none; border-bottom: 0.5px; } 
        table td,th:last-child { border-right: none; }

        .table-container::-webkit-scrollbar {
            display: none;
        } 

        .table-container::-webkit-scrollbar {
            display: none; 
        }

        .table-container {
            scrollbar-width: none; 
        }

        input:focus, textarea:focus, select:focus{
            outline: none;
        }
        input, textarea, select{
            outline: none;
        }

        .flex {
            display: flex;
        }

        .summary-container {
            display: none;
        }
    </style>
</head>
<body>
    <div class="color mt-[48px] px-[10px] md:px-[70px]">
        <div class="flex w-full flex-col lg:flex-row  justify-between">
            <!--1st col-->
            <div class="w-full h-full lg:w-5/12 pr-0 lg:pr-3 pb-6">
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
                            <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Initial Investment :</p>
                            <div class="flex relative">
                                <input type="number" value="5000" id="initial_investment" style="outline: none;"
                                    class="mt-[14px] outline-none border-none text-[#132813] text-[16px] ml-[60px] ps-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-r-[8px]">
                                <div class="w-[60px] absolute left-0 mt-[14px] h-[50px] text-[16px] border-r rounded-l-[8px] bg-[#EBEBEB]  border-[#132813]">
                                    <p name="currency" class="flex justify-center text-[16px] items-center my-3">$</p>
                                </div>
                            </div>
                        </div>
                        <!---Interest rate-->
                        <div class="px-[24px]">
                            <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Interest rate :</p>
                            <div class="flex">
                                <div class="w-5/12 relative flex pr-3">
                                    <input type="number" value="5" id="interest_rate"
                                        class="mt-[14px] text-[#132813] text-[16px] border-none outline-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                    
                                        <p class="text-[16px] absolute right-5 text-[#132813] top-[28px] font-normal">%</p>
                              
                                </div>
                                <!-- <div class="w-5/12 pl-3">
                                    <select id="interest_period"
                                        class="mt-[16px] custom-select-wrapper text-[16px] outline-none text-[#132813] px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <option value="Daily">Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Monthly" selected>Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div> -->
                                <!-- Select menu div contains custom arrow -->
                                <div
                                    class="relative flex w-5/12 pl-3 items-center after:w-[10px] after:h-[10px] after:border-black/70 after:border-b after:mt-[7px] after:border-r after:transform after:rotate-45 after:absolute after:right-3">
                                    <!-- Select menu -->
                                    <select id="interest_period"
                                        class="text-[#132813] px-[15px] mt-[14px] bg-[#EBEBEB] text-[16px] transition-all cursor-pointer w-full h-[50px] rounded-[8px] appearance-none">
                                        <option value="Daily">Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Monthly" selected>Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!---Years and Month-->
                        <div class="px-[24px] flex">
                            <div class="pr-3 w-5/12">
                                <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Years :</p>
                                <input type="number" value="5" id="interest_year" min="0" max="200" oninput="validity.valid||(value='');"
                                    class="mt-[14px] text-[#132813]  outline-none text-[16px] px-[15px] border-none w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                            </div>
                            <div class="pl-3 w-5/12">
                                <p class="pt-[28px] text-[16px] text-[#000000] font-normal">Month :</p>
                                <input type="number" placeholder="0" id="interest_month" min="0" max="12" step="1" oninput="validity.valid||(value='');"
                                    class="mt-[14px] text-[#132813] text-[16px] outline-none border-none px-[15px] w-full bg-[#EBEBEB] h-[50px] rounded-[8px]">
                            </div>
                        </div>
                        <!---Line--->
                        <div class="px-[12px] mt-[30px]">
                            <hr class="">
                        </div>
                        <!---Compound interval--->
                        <!-- <div class="px-[24px] pb-6">
                            <div class="flex pt-[28px] text-[16px] font-normal">
                                <p class="text-[#000000]">Compound interval</p>
                            </div>
                            <div class="flex">
                                <div class="relative mb-3 flex w-6/12 pr-3 items-center after:w-[10px] after:h-[10px] after:mt-[10px] after:border-black/70 after:border-b after:border-r after:transform after:rotate-45 after:absolute after:right-6">
                                    <select id="compound_interval"
                                        class="text-[#132813] px-[15px] mt-[16px] bg-[#EBEBEB] text-[16px] transition-all cursor-pointer w-full h-[50px] rounded-[8px] appearance-none">
                                        <option class="" value="daily-365">Daily (365/yr)</option>
                                        <option value="daily-360">Daily (360/yr)</option>
                                        <option value="weekly-104">Semi-Weekly (104/yr)</option>
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
                                <div onclick="calculate()" class="pl-3 w-6/12 cursor-pointer mr-[16px]">
                                    <div
                                        class="bg-[#132813] h-[50px] cursor-pointer w-full mt-[16px] mx-[16px] rounded-[8px] items-center justify-center flex">
                                        <svg class="mr-[16px]" width="18" height="20" viewBox="0 0 18 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.5 9.25H13.5C13.6989 9.25 13.8897 9.17098 14.0303 9.03033C14.171 8.88968 14.25 8.69891 14.25 8.5V4C14.25 3.80109 14.171 3.61032 14.0303 3.46967C13.8897 3.32902 13.6989 3.25 13.5 3.25H4.5C4.30109 3.25 4.11032 3.32902 3.96967 3.46967C3.82902 3.61032 3.75 3.80109 3.75 4V8.5C3.75 8.69891 3.82902 8.88968 3.96967 9.03033C4.11032 9.17098 4.30109 9.25 4.5 9.25ZM5.25 4.75H12.75V7.75H5.25V4.75ZM15.75 0.25H2.25C1.85218 0.25 1.47064 0.408035 1.18934 0.68934C0.908035 0.970644 0.75 1.35218 0.75 1.75V18.25C0.75 18.6478 0.908035 19.0294 1.18934 19.3107C1.47064 19.592 1.85218 19.75 2.25 19.75H15.75C16.1478 19.75 16.5294 19.592 16.8107 19.3107C17.092 19.0294 17.25 18.6478 17.25 18.25V1.75C17.25 1.35218 17.092 0.970644 16.8107 0.68934C16.5294 0.408035 16.1478 0.25 15.75 0.25ZM15.75 18.25H2.25V1.75H15.75V18.25ZM6.375 11.875C6.375 12.0975 6.30902 12.315 6.1854 12.5C6.06179 12.685 5.88609 12.8292 5.68052 12.9144C5.47495 12.9995 5.24875 13.0218 5.03052 12.9784C4.81229 12.935 4.61184 12.8278 4.4545 12.6705C4.29717 12.5132 4.19002 12.3127 4.14662 12.0945C4.10321 11.8762 4.12549 11.65 4.21064 11.4445C4.29578 11.2389 4.43998 11.0632 4.62498 10.9396C4.80999 10.816 5.0275 10.75 5.25 10.75C5.54837 10.75 5.83452 10.8685 6.0455 11.0795C6.25647 11.2905 6.375 11.5766 6.375 11.875ZM10.125 11.875C10.125 12.0975 10.059 12.315 9.9354 12.5C9.81179 12.685 9.63608 12.8292 9.43052 12.9144C9.22495 12.9995 8.99875 13.0218 8.78052 12.9784C8.56229 12.935 8.36184 12.8278 8.2045 12.6705C8.04717 12.5132 7.94002 12.3127 7.89662 12.0945C7.85321 11.8762 7.87549 11.65 7.96064 11.4445C8.04578 11.2389 8.18998 11.0632 8.37498 10.9396C8.55999 10.816 8.7775 10.75 9 10.75C9.29837 10.75 9.58452 10.8685 9.79549 11.0795C10.0065 11.2905 10.125 11.5766 10.125 11.875ZM13.875 11.875C13.875 12.0975 13.809 12.315 13.6854 12.5C13.5618 12.685 13.3861 12.8292 13.1805 12.9144C12.975 12.9995 12.7488 13.0218 12.5305 12.9784C12.3123 12.935 12.1118 12.8278 11.9545 12.6705C11.7972 12.5132 11.69 12.3127 11.6466 12.0945C11.6032 11.8762 11.6255 11.65 11.7106 11.4445C11.7958 11.2389 11.94 11.0632 12.125 10.9396C12.31 10.816 12.5275 10.75 12.75 10.75C13.0484 10.75 13.3345 10.8685 13.5455 11.0795C13.7565 11.2905 13.875 11.5766 13.875 11.875ZM6.375 15.625C6.375 15.8475 6.30902 16.065 6.1854 16.25C6.06179 16.435 5.88609 16.5792 5.68052 16.6644C5.47495 16.7495 5.24875 16.7718 5.03052 16.7284C4.81229 16.685 4.61184 16.5778 4.4545 16.4205C4.29717 16.2632 4.19002 16.0627 4.14662 15.8445C4.10321 15.6262 4.12549 15.4 4.21064 15.1945C4.29578 14.9889 4.43998 14.8132 4.62498 14.6896C4.80999 14.566 5.0275 14.5 5.25 14.5C5.54837 14.5 5.83452 14.6185 6.0455 14.8295C6.25647 15.0405 6.375 15.3266 6.375 15.625ZM10.125 15.625C10.125 15.8475 10.059 16.065 9.9354 16.25C9.81179 16.435 9.63608 16.5792 9.43052 16.6644C9.22495 16.7495 8.99875 16.7718 8.78052 16.7284C8.56229 16.685 8.36184 16.5778 8.2045 16.4205C8.04717 16.2632 7.94002 16.0627 7.89662 15.8445C7.85321 15.6262 7.87549 15.4 7.96064 15.1945C8.04578 14.9889 8.18998 14.8132 8.37498 14.6896C8.55999 14.566 8.7775 14.5 9 14.5C9.29837 14.5 9.58452 14.6185 9.79549 14.8295C10.0065 15.0405 10.125 15.3266 10.125 15.625ZM13.875 15.625C13.875 15.8475 13.809 16.065 13.6854 16.25C13.5618 16.435 13.3861 16.5792 13.1805 16.6644C12.975 16.7495 12.7488 16.7718 12.5305 16.7284C12.3123 16.685 12.1118 16.5778 11.9545 16.4205C11.7972 16.2632 11.69 16.0627 11.6466 15.8445C11.6032 15.6262 11.6255 15.4 11.7106 15.1945C11.7958 14.9889 11.94 14.8132 12.125 14.6896C12.31 14.566 12.5275 14.5 12.75 14.5C13.0484 14.5 13.3345 14.6185 13.5455 14.8295C13.7565 15.0405 13.875 15.3266 13.875 15.625Z"
                                                fill="#E1E1E1" />
                                        </svg>
                                        <p class="text-[16px] text-[#FFFFFF] font-normal">Calculate</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div id="calculate" class="w-5/12 pb-6 mt-[16px]">
                            <div
                                class="bg-[#132813] h-[50px] cursor-pointer w-full mx-[16px] rounded-[8px] items-center justify-center flex">
                                <svg class="mr-[16px]" width="18" height="20" viewBox="0 0 18 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.5 9.25H13.5C13.6989 9.25 13.8897 9.17098 14.0303 9.03033C14.171 8.88968 14.25 8.69891 14.25 8.5V4C14.25 3.80109 14.171 3.61032 14.0303 3.46967C13.8897 3.32902 13.6989 3.25 13.5 3.25H4.5C4.30109 3.25 4.11032 3.32902 3.96967 3.46967C3.82902 3.61032 3.75 3.80109 3.75 4V8.5C3.75 8.69891 3.82902 8.88968 3.96967 9.03033C4.11032 9.17098 4.30109 9.25 4.5 9.25ZM5.25 4.75H12.75V7.75H5.25V4.75ZM15.75 0.25H2.25C1.85218 0.25 1.47064 0.408035 1.18934 0.68934C0.908035 0.970644 0.75 1.35218 0.75 1.75V18.25C0.75 18.6478 0.908035 19.0294 1.18934 19.3107C1.47064 19.592 1.85218 19.75 2.25 19.75H15.75C16.1478 19.75 16.5294 19.592 16.8107 19.3107C17.092 19.0294 17.25 18.6478 17.25 18.25V1.75C17.25 1.35218 17.092 0.970644 16.8107 0.68934C16.5294 0.408035 16.1478 0.25 15.75 0.25ZM15.75 18.25H2.25V1.75H15.75V18.25ZM6.375 11.875C6.375 12.0975 6.30902 12.315 6.1854 12.5C6.06179 12.685 5.88609 12.8292 5.68052 12.9144C5.47495 12.9995 5.24875 13.0218 5.03052 12.9784C4.81229 12.935 4.61184 12.8278 4.4545 12.6705C4.29717 12.5132 4.19002 12.3127 4.14662 12.0945C4.10321 11.8762 4.12549 11.65 4.21064 11.4445C4.29578 11.2389 4.43998 11.0632 4.62498 10.9396C4.80999 10.816 5.0275 10.75 5.25 10.75C5.54837 10.75 5.83452 10.8685 6.0455 11.0795C6.25647 11.2905 6.375 11.5766 6.375 11.875ZM10.125 11.875C10.125 12.0975 10.059 12.315 9.9354 12.5C9.81179 12.685 9.63608 12.8292 9.43052 12.9144C9.22495 12.9995 8.99875 13.0218 8.78052 12.9784C8.56229 12.935 8.36184 12.8278 8.2045 12.6705C8.04717 12.5132 7.94002 12.3127 7.89662 12.0945C7.85321 11.8762 7.87549 11.65 7.96064 11.4445C8.04578 11.2389 8.18998 11.0632 8.37498 10.9396C8.55999 10.816 8.7775 10.75 9 10.75C9.29837 10.75 9.58452 10.8685 9.79549 11.0795C10.0065 11.2905 10.125 11.5766 10.125 11.875ZM13.875 11.875C13.875 12.0975 13.809 12.315 13.6854 12.5C13.5618 12.685 13.3861 12.8292 13.1805 12.9144C12.975 12.9995 12.7488 13.0218 12.5305 12.9784C12.3123 12.935 12.1118 12.8278 11.9545 12.6705C11.7972 12.5132 11.69 12.3127 11.6466 12.0945C11.6032 11.8762 11.6255 11.65 11.7106 11.4445C11.7958 11.2389 11.94 11.0632 12.125 10.9396C12.31 10.816 12.5275 10.75 12.75 10.75C13.0484 10.75 13.3345 10.8685 13.5455 11.0795C13.7565 11.2905 13.875 11.5766 13.875 11.875ZM6.375 15.625C6.375 15.8475 6.30902 16.065 6.1854 16.25C6.06179 16.435 5.88609 16.5792 5.68052 16.6644C5.47495 16.7495 5.24875 16.7718 5.03052 16.7284C4.81229 16.685 4.61184 16.5778 4.4545 16.4205C4.29717 16.2632 4.19002 16.0627 4.14662 15.8445C4.10321 15.6262 4.12549 15.4 4.21064 15.1945C4.29578 14.9889 4.43998 14.8132 4.62498 14.6896C4.80999 14.566 5.0275 14.5 5.25 14.5C5.54837 14.5 5.83452 14.6185 6.0455 14.8295C6.25647 15.0405 6.375 15.3266 6.375 15.625ZM10.125 15.625C10.125 15.8475 10.059 16.065 9.9354 16.25C9.81179 16.435 9.63608 16.5792 9.43052 16.6644C9.22495 16.7495 8.99875 16.7718 8.78052 16.7284C8.56229 16.685 8.36184 16.5778 8.2045 16.4205C8.04717 16.2632 7.94002 16.0627 7.89662 15.8445C7.85321 15.6262 7.87549 15.4 7.96064 15.1945C8.04578 14.9889 8.18998 14.8132 8.37498 14.6896C8.55999 14.566 8.7775 14.5 9 14.5C9.29837 14.5 9.58452 14.6185 9.79549 14.8295C10.0065 15.0405 10.125 15.3266 10.125 15.625ZM13.875 15.625C13.875 15.8475 13.809 16.065 13.6854 16.25C13.5618 16.435 13.3861 16.5792 13.1805 16.6644C12.975 16.7495 12.7488 16.7718 12.5305 16.7284C12.3123 16.685 12.1118 16.5778 11.9545 16.4205C11.7972 16.2632 11.69 16.0627 11.6466 15.8445C11.6032 15.6262 11.6255 15.4 11.7106 15.1945C11.7958 14.9889 11.94 14.8132 12.125 14.6896C12.31 14.566 12.5275 14.5 12.75 14.5C13.0484 14.5 13.3345 14.6185 13.5455 14.8295C13.7565 15.0405 13.875 15.3266 13.875 15.625Z"
                                        fill="#E1E1E1" />
                                </svg>
                                <p class="text-[16px] text-[#FFFFFF] font-normal">Calculate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--2nd col-->
            <div class="w-full lg:w-7/12 lg:pl-3 pl-0 h-full mb-10">
                <div class="bg-[#F4F4F4] rounded-[8px]">
                    <!--Status bar-->
                    <div role="status" id="status" style="display: none" class="flex items-center justify-center py-[318px]">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-[#132813]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <!--Calculation body-->
                    <div class="mt-0" id="content">
                        <div class="flex pt-6 pl-6 pr-[10px] text-[24px] font-medium leading-[29px] text-[#132815]">
                            <p class="">Interest Calculation For <span id="interest_year_value">5 Years</span>
                            </p>
                        </div>
                        <!---Line--->
                        <div class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <div class="mt-[24px] pl-6 pr-[8px]">
                            <div class="flex flex-col lg:flex-row justify-between">
                                <!--1st col -->
                                <div class="w-full lg:w-[43%]" id="firstColumn">
                                    <p class="text-[18px]">Future investment value</p>
                                    <p class="text-[26px] pt-3 text-[#61CE70EE] leading-[34px] truncate font-bold" id="future_value">$6,416.79</p>
                                </div>
                                <!--2nd col -->
                                <div class="w-full lg:w-[6%] lg:mx-2 items-center" id="secondColumn">
                                    <div class="flex items-center">
                                        <p></p>
                                        <svg onclick="copyFutureValue()" class="cursor-pointer mt-[10px] lg:mt-[46px]" id="copy_future_value" width="25" height="25" viewBox="0 0 25 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M23.8438 0.125H7.34375C7.07025 0.125 6.80794 0.233649 6.61455 0.427046C6.42115 0.620443 6.3125 0.882746 6.3125 1.15625V6.3125H1.15625C0.882746 6.3125 0.620443 6.42115 0.427046 6.61455C0.233649 6.80794 0.125 7.07025 0.125 7.34375V23.8438C0.125 24.1173 0.233649 24.3796 0.427046 24.573C0.620443 24.7664 0.882746 24.875 1.15625 24.875H17.6562C17.9298 24.875 18.1921 24.7664 18.3855 24.573C18.5789 24.3796 18.6875 24.1173 18.6875 23.8438V18.6875H23.8438C24.1173 18.6875 24.3796 18.5789 24.573 18.3855C24.7664 18.1921 24.875 17.9298 24.875 17.6562V1.15625C24.875 0.882746 24.7664 0.620443 24.573 0.427046C24.3796 0.233649 24.1173 0.125 23.8438 0.125ZM16.625 22.8125H2.1875V8.375H16.625V22.8125ZM22.8125 16.625H18.6875V7.34375C18.6875 7.07025 18.5789 6.80794 18.3855 6.61455C18.1921 6.42115 17.9298 6.3125 17.6562 6.3125H8.375V2.1875H22.8125V16.625Z"
                                                fill="#BEBEBE" />
                                        </svg>
                                        <svg id="copied_future_value" style="display: none;"  xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#61CE70EE" class="bi bi-check2 mt-[10px] lg:mt-[46px]" viewBox="0 0 16 16">
                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                                        </svg>
                                    </div>
                                </div>
                                <!--3rd col -->
                                <div class="w-full md:w-[51%]" id="thirdColumn">
                                    <div class="flex items-center">
                                        <p class="text-[18px] lg:mt-0 mt-3 pr-1">Interest rate</p>
                                        <p id="interest_period_value" class="px-1 lg:mt-0 mt-3 text-[18px]">( yearly ) </p>
                                    </div>
                                    <div class="flex items-center pt-4 text-[26px] text-left justify-start text-[#BEBEBE] leading-[34px] font-bold">
                                        <p id="interest_rate_value" class="">5</p>
                                        <p class="">%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-[24px] pl-6 pr-[0px]">
                            <div class="flex flex-col lg:flex-row justify-between">
                                <!--1st col -->
                                <div class="w-full lg:w-[43%]">
                                    <p class="text-[18px]">Total interest earned</p>
                                    <p class="text-[26px] pt-4 text-[#BA924A] leading-[34px] truncate font-bold" id="total_interest_earned">$1,416.79</p>
                                </div>
                                <!--2nd col -->
                                <div class="w-full lg:w-[6%] lg:mx-2 items-center">
                                    <div class="flex items-center">
                                        <p></p>
                                        <svg onclick="copyTotalInterest()" class="cursor-pointer mt-[10px] lg:mt-[46px]" id="copy_total_interest" width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M23.8438 0.125H7.34375C7.07025 0.125 6.80794 0.233649 6.61455 0.427046C6.42115 0.620443 6.3125 0.882746 6.3125 1.15625V6.3125H1.15625C0.882746 6.3125 0.620443 6.42115 0.427046 6.61455C0.233649 6.80794 0.125 7.07025 0.125 7.34375V23.8438C0.125 24.1173 0.233649 24.3796 0.427046 24.573C0.620443 24.7664 0.882746 24.875 1.15625 24.875H17.6562C17.9298 24.875 18.1921 24.7664 18.3855 24.573C18.5789 24.3796 18.6875 24.1173 18.6875 23.8438V18.6875H23.8438C24.1173 18.6875 24.3796 18.5789 24.573 18.3855C24.7664 18.1921 24.875 17.9298 24.875 17.6562V1.15625C24.875 0.882746 24.7664 0.620443 24.573 0.427046C24.3796 0.233649 24.1173 0.125 23.8438 0.125ZM16.625 22.8125H2.1875V8.375H16.625V22.8125ZM22.8125 16.625H18.6875V7.34375C18.6875 7.07025 18.5789 6.80794 18.3855 6.61455C18.1921 6.42115 17.9298 6.3125 17.6562 6.3125H8.375V2.1875H22.8125V16.625Z"
                                                    fill="#BEBEBE" />
                                        </svg>
                                        <svg id="copied_total_interest" style="display: none" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#61CE70EE" class="bi bi-check2 mt-[10px] lg:mt-[46px]" viewBox="0 0 16 16">
                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                                        </svg>
                                    </div>
                                </div>
                                <!--3rd col -->
                                <div class="w-full lg:w-[51%]">
                                    <div class="flex items-center lg:mt-0 mt-3">
                                        <p class="text-[18px]">All-time rate of Return ( RoR )</p>
                                    </div>
                                    <div class="flex items-center mt-4 text-[26px] text-left justify-start text-[#BEBEBE] leading-[34px] font-bold">
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
                                            <p class="ml-4 text-[26px] text-[#BEBEBE] leading-[34px] truncate font-bold" id="ror">28.34%
                                                </p>
                                                <svg id="ror_svg" class="ml-6 cursor-pointer" width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.25" y="0.25" width="16.5" height="16.5" stroke="#B3B3B3"
                                                        stroke-width="0.5" />
                                                    <path
                                                        d="M7.664 10.216C7.664 8.44 9.668 8.104 9.668 6.904C9.668 6.232 9.092 5.776 8.168 5.776C7.28 5.776 6.632 6.112 6.212 6.7L5.048 5.944C5.72 5.032 6.8 4.48 8.3 4.48C10.064 4.48 11.24 5.284 11.24 6.664C11.24 8.62 9.188 8.8 9.188 10.216H7.664ZM8.432 13.084C7.868 13.084 7.472 12.664 7.472 12.148C7.472 11.632 7.868 11.224 8.432 11.224C8.984 11.224 9.38 11.632 9.38 12.148C9.38 12.664 8.984 13.084 8.432 13.084Z"
                                                        fill="#8E8E8E" />
                                                </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 px-6 flex flex-col lg:flex-row ">
                            <div class="w-6/12 lg:order-1 order-2 lg:mt-0 mt-6">
                                <p class="text-[18px]">Initial balance</p>
                                <p class="pt-3 text-[26px] text-[#132815] font-bold" id="initial_balance">$5,000.00</p>
                            </div>
                            <div class="w-6/12 -mt-4 pl-4 lg:order-2 order-1">
                                <p id="ror_brief" style="display: none" class="text-[12px]">The RoR represents the profit or loss % returned from your investment over the entire investment term.</p>
                            </div>
                        </div>
                        <!---Line--->
                        <div class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <div class="mt-[24px] px-6">
                            <div class="flex w-full flex-col lg:flex-row">
                                <div class="lg:pr-3 w-[220px]">
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
                                <div class="lg:pl-3 lg:mt-0 mt-5 w-full lg:w-[220px]">
                                    <p class="text-[16px]">Table<b> / </b>chart <b> / </b> summery</p>
                                    <div
                                        class="flex w-[165px] items-center mt-[16px] bg-[#EBEBEB] h-[50px] rounded-[8px]">
                                        <svg onclick="toggleTable()" class="cursor-pointer ml-[26px]" id="table_svg" width="22" height="24" viewBox="0 0 22 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.40002 7.2H16.6M5.40002 13.6H7.00002M10.2 13.6H11.8M15 13.6H16.6M5.40002 18.4H7.00002M10.2 18.4H11.8M15 18.4H16.6M3.00002 23.2H19C19.4244 23.2 19.8313 23.0314 20.1314 22.7314C20.4315 22.4313 20.6 22.0243 20.6 21.6V2.4C20.6 1.97566 20.4315 1.56869 20.1314 1.26863C19.8313 0.968574 19.4244 0.800003 19 0.800003H3.00002C2.57568 0.800003 2.16871 0.968574 1.86865 1.26863C1.5686 1.56869 1.40002 1.97566 1.40002 2.4V21.6C1.40002 22.0243 1.5686 22.4313 1.86865 22.7314C2.16871 23.0314 2.57568 23.2 3.00002 23.2Z"
                                                stroke="#61CE70" stroke-opacity="0.933333" stroke-width="2" />
                                        </svg>
                                        <svg onclick="toggleChart()" class="cursor-pointer ml-[26px]" id="chart_svg" width="20" height="18" viewBox="0 0 20 18"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14 8.78L18.24 1.45L19.97 2.45L14.74 11.5L8.23 7.75L3.46 16H20V18H0V0H2V14.54L7.5 5L14 8.78Z"
                                                fill="#B9B9B9" />
                                        </svg>
                                        <svg id="summary_svg" class="cursor-pointer ml-[26px]" width="20" height="22" viewBox="0 0 20 22"
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
                         <div id="summary_line" style="display: none;" class="mt-[24px] px-6">
                            <hr class="">
                        </div>
                        <!--Summary-->
                        <div class="mt-6 px-6" style="display: none;"  id="summary_container">
                            <p class="text-[#132813] text-[24px] mt-2 font-normal">Summary</p>
                            <div class="text-[16px] mt-4 flex text-left items-center">
                                <p class="font-medium w-5/12">Initial Deposit :</p>
                                <p id="summary_initial_deposit" class="font-normal ml-2">$5,000.00</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-medium w-5/12">Interest Rate :</p>
                                <p id="summary_interest_rate" class="font-normal ml-2">5%</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-medium w-5/12">Effective Rate :</p>
                                <p id="summary_effective_rate" class="font-normal ml-2">5.12%</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-medium w-5/12">Time :</p>
                                <p id="summary_time" class="font-normal ml-2">5 Years</p>
                            </div>
                            <div class="text-[16px] flex text-left items-center">
                                <p class="font-medium w-5/12">Compounding :</p>
                                <p id="summary_compounding" class="font-normal ml-2">Monthly</p>
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
                            <div id="table" class="mt-10 table-container lg:px-6 px-2 relative h-[430px] overflow-y-scroll">
                                <table class="w-full">
                                    <thead class="">
                                        <tr class="text-[16px] text-center items-center">
                                            <th id="tyear" class="bg-[#BA924A] w-[151px] text-center text-[#ffffff]">Year</th>
                                            <th class="bg-[#BA924A] w-[151px] text-left pl-6 text-[#ffffff]">Interest</th>
                                            <th class="bg-[#132813] w-[151px] text-left pl-6 text-[#ffffff]">Accrued
                                                interest</th>
                                            <th class="bg-[#61CE70]  w-[151px] text-left pl-6 text-[#ffffff]">balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody" class="overflow-y-auto max-h-[360px] relative">
                                        <tr class="h-[45px] text-[16px] border-b-[0.5px] bg-[#ffffff]">
                                            <td class="text-center">0</td>
                                            <td class="text-left pl-6">-</td>
                                            <td class="text-left pl-6">-</td>
                                            <td class="text-left pl-6">$5000.00</td>
                                        </tr>
                                        <tr class="h-[45px] text-[16px] border-b-[0.5px] bg-[#ffffff]">
                                            <td class="text-center">1</td>
                                            <td class="text-left pl-6">$255.81</td>
                                            <td class="text-left pl-6">$255.81</td>
                                            <td class="text-left pl-6">$5255.81</td>
                                        </tr>
                                        <tr class="h-[45px] text-[16px] border-b-[0.5px] bg-[#ffffff]">
                                            <td class="text-center">2</td>
                                            <td class="text-left pl-6">$268.90</td>
                                            <td class="text-left pl-6">$524.71</td>
                                            <td class="text-left pl-6">$5554.71</td>
                                        </tr>
                                        <tr class="h-[45px] text-[16px] border-b-[0.5px] bg-[#ffffff]">
                                            <td class="text-center">3</td>
                                            <td class="text-left pl-6">$282.65</td>
                                            <td class="text-left pl-6">$807.36</td>
                                            <td class="text-left pl-6">$5807.36</td>
                                        </tr>
                                        <tr class="h-[45px] text-[16px] border-b-[0.5px] bg-[#ffffff]">
                                            <td class="text-center">4</td>
                                            <td class="text-left pl-6">$297.12</td>
                                            <td class="text-left pl-6">$1104.48</td>
                                            <td class="text-left pl-6">$6104.48</td>
                                        </tr>
                                        <tr class="h-[45px] text-[16px] border-b-[0.5px] text-[#ffffff] bg-[#132813]">
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
                            <div id="month_data_table" class="table-container mt-10 lg:px-6 px-2 relative h-[430px] overflow-y-scroll">
                                <table class="border-2 w-full">
                                    <thead class="h-[60px]">
                                        <tr class="text-[16px]">
                                            <th class="bg-[#BA924A] w-[151px] text-center text-[#ffffff]">Month</th>
                                            <th class="bg-[#BA924A] w-[151px] text-left pl-6 text-[#ffffff]">Interest</th>
                                            <th class="bg-[#132813] w-[151px] text-left pl-6 text-[#ffffff]">Accrued
                                                interest</th>
                                            <th class="bg-[#61CE70] w-[151px] text-left pl-6 text-[#ffffff]">balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="month_tbody" class="overflow-y-auto max-h-[360px] relative z-0">
                                        <tr class="h-[45px] border-b bg-[#ffffff]">
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                  
                        </div>
                        <!--Chart-->
                        <div id="chart" style="display: none" class="chart-container mt-10" style="position: relative; height:40vh; width:80vw">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
