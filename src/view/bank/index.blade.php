<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Bank</title>
</head>
<body class="bg-gray-100 flex items-center justify-center">

    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded my-6">
            <div class="text-center py-4">
                @include('partials.header')
            </div>

            <div class="px-12 pb-10 space-y-10">
                <div class="text-center text-5xl font-bold">Bank Operations</div>

                <div class="flex justify-center space-x-10">
                    @if($current_date)
                        <div class="text-center text-xl mt-3">Current date: {{ $current_date }}</div>
                    @else
                        <div class="text-center text-xl mt-3">Current date isn't set</div>
                    @endif
                    <form action="/controller/bank/close_the_day.php" onsubmit="return confirm('Are you sure you want to close the banking day?');" method="post" class="mb-4 space-x-10">
                        <input type="submit" value="Close The Banking Day" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-outduration-200">
                        <input type="number" name="days" min="1" value="1" required>
                    </form>                    
                </div>

                <div class="flex justify-center space-x-10">
                    <form action="/controller/deposits/clear.php" onsubmit="return confirm('Are you sure you want to clear all deposits?');" method="post" class="mb-4">
                        <input type="submit" value="Clear Deposits" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/deposit_types/clear.php" onsubmit="return confirm('Are you sure you want to clear all deposit types?');" method="post" class="mb-4">
                        <input type="submit" value="Clear Deposit Types" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/credits/clear.php" onsubmit="return confirm('Are you sure you want to clear all credits?');" method="post" class="mb-4">
                        <input type="submit" value="Clear Credits" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/credit_types/clear.php" onsubmit="return confirm('Are you sure you want to clear all credit types?');" method="post" class="mb-4">
                        <input type="submit" value="Clear Credit Types" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>
                </div>

                <div class="flex justify-center space-x-10">
                    <form action="/controller/accounts/clear.php" onsubmit="return confirm('Are you sure you want to clear all accounts?');" method="post" class="mb-4">
                        <input type="submit" value="Сlear Accounts" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/currencies/clear.php" onsubmit="return confirm('Are you sure you want to clear all currencies?');" method="post" class="mb-4">
                        <input type="submit" value="Clear Currencies" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/bank/clear_the_day.php" onsubmit="return confirm('Are you sure you want to set the current date to 2024-02-13?');" method="post" class="mb-4">
                        <input type="submit" value="Refresh Day" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/bank/restart.php" onsubmit="return confirm('Are you sure you want to restart all of the bank system?');" method="post" class="mb-4">
                        <input type="submit" value="Restart System" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/../../js/script.js"></script>

</body>
</html>