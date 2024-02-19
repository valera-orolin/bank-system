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
                <div class="text-center text-5xl font-bold">ATM</div>

                <div class="flex justify-center space-x-10">
                    <form action="/controller/atm/balance_inquiry.php" method="post" class="auth-form mb-4">
                        <input type="hidden" name="number" class="hidden-number">
                        <input type="hidden" name="pin" class="hidden-pin">
                        <input type="submit" value="Balance Inquiry" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>
                    
                    <form action="/controller/atm/cash_withdrawal/index.php" method="post" class="auth-form mb-4">
                        <input type="hidden" name="number" class="hidden-number">
                        <input type="hidden" name="pin" class="hidden-pin">
                        <input type="submit" value="Cash Withdrawal" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/atm/payment/index.php" method="post" class="mb-4 auth-form">
                        <input type="hidden" name="number" class="hidden-number">
                        <input type="hidden" name="pin" class="hidden-pin">
                        <input type="submit" value="Payment" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>

                    <form action="/controller/atm/index.php" method="post" id="pickUpForm" class="mb-4">
                        <input type="submit" value="Pick Up The Card" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>
                </div>

                <div class="text-center">{{ $message }}</div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.auth-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                var number = localStorage.getItem('number');
                var pin = localStorage.getItem('pin');

                form.querySelector('.hidden-number').value = number;
                form.querySelector('.hidden-pin').value = pin;
            });
        });

        document.getElementById('pickUpForm').addEventListener('submit', function(e) {
            localStorage.removeItem('number');
            localStorage.removeItem('pin');
        });
    </script>

</body>
</html>