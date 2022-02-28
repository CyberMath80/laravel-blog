Hello world !

@if($number < 5)
   <p>{{$number}} Inférieur à 5</p>
@elseif($number== 5)
    <p>{{$number}} Égal à 5</p>
@else
    <p>{{$number}} Supérieur à 5</p>
@endif

@for($i = 0; $i < $number; $i++)
    <p>Nombre égal à {{ $i }}.</p>
@endfor

@unless($number == 5)
    <p>Nombre est différent de 5</p>
@endunless

@foreach($voitures as $voiture)
    <p>La marque est {{$voiture}}</p>
@endforeach

@forelse($fruits as $fruit)
    <p>Le fruit est {{$fruit}}</p>
@empty
    <p>Il n'y a pas de fruits</p>
@endforelse

@php
    echo rand(1, 15);
    // echo phpinfo();
@endphp

@isset($fruits)
    <p>il y a {{count($fruits)}} fruits</p>
@endisset

@switch($number)
    @case(2)
        <p>Nombre est égal à {{ $number }}</p>
    @break

    @case(15)
        <p>Nombre est égal à {{ $number }}</p>
    @break

    @default
        <p>Nombre n'est ni égal à 2 ni égal 15</p>
@endswitch
