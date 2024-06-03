
@extends('app')

@section('title', '404 Not Found')

@section('content')
    
    <style>

        #countUp {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto Mono', monospace;

            .number {
                font-weight: 350 !important;
                text-align: center;
                color: white;
                font-size: 7rem;
                margin-top: 5rem;
            }

            .text {
                font-weight: 350 !important;
                font-size: 2rem;
                text-align: center;
                color: white;
            }
        }
    </style>
    <section class="py-5">
        
    <div class="animate" id="countUp">
        <h1 class='h1-services animate-slide fw-bolder text-white text-center number' data-count="404">0</h1>

        
        <div class="text fw-bolder animate-slide">Page not found </div>
        <div class="text animate-slide">Gapenting sih, tapi mau bagaimana lagi.</div>
        <div class="text animate-slide">Turu Turu Turu 😴😴😴💤.</div><br>
        <button class="btn btn-outline-light animate-slide" type="submit" onclick="window.location.href='/'">sini, Balik Home Ajah</button>
    </div>

    <script>
        const countUp = document.querySelector('#countUp .number');
        const countUpText = document.querySelector('#countUp .text');
        const countUpNum = parseInt(countUp.dataset.count, 10);
        const delay = 10;
        const speed = 1000 / countUpNum;

        let counter = 0;

        const countUpTick = () => {
            if (counter < countUpNum) {
                counter++;
                countUp.innerText = counter;
                setTimeout(countUpTick, speed);
            } else {
                countUpText.innerText = 'Page not found';
            }
        }

        setTimeout(countUpTick, delay);
    </script>

@endsection