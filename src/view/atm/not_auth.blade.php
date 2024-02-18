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
                    <form action="/controller/atm/restart.php" onsubmit="return confirm('Are you sure you want to restart ATM?');" method="post" class="mb-4">
                        <input type="submit" value="Restart ATM" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-out duration-200">
                    </form>
                </div>

                <div class="flex justify-center space-x-10">
                    <form action="/controller/atm/index.php" method="post" class="mb-4 space-x-10" id="authForm">
                        <input type="text" name="number" maxlength="16" minlength="16" value="1234567890123456" required>
                        <input type="text" name="pin" maxlength="4" minlength="4" value="1234" required>
                        <input type="submit" value="Submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all ease-in-outduration-200">
                    </form>     
                </div>

                <div class="text-center">{{ $message }}</div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('authForm').addEventListener('submit', function(e) {
            var number = e.target.elements.number.value;
            var pin = e.target.elements.pin.value;

            localStorage.setItem('number', number);
            localStorage.setItem('pin', pin);
        });
    </script>

</body>
</html>
