

@extends('app')

@section('title', 'Home')

<title>Redirecting to WhatsApp</title>
<script>
        window.onload = function() {
            document.getElementById('whatsapp-link').click();
            setTimeout(function() {
                window.location.href = "/";
            }, 1000); // Optional: Redirect to home page after opening the new tab
        };
</script>

@section('content')

<section>
    
    <a id="whatsapp-link" href="{{ $url }}" target="_blank" style="display:none;">Open WhatsApp</a>
</section>

@endsection