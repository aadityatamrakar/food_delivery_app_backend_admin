<?php
$cuisines = ["American",  "Andhra",  "Arabic",  "Bakery",  "Biryani",  "Burgers",  "Cafe",  "Cakes-Bakery",  "Chinese",  "Continental",  "Desserts",  "Fast Food",  "Ice creams",  "Italian",  "Japanese",  "Kebab",  "Mexican",  "Mughlai",  "Multi-cuisine",  "North Indian",  "Pan-Asian",  "Pizza",  "Punjabi",  "Salads",  "Sandwiches",  "Snacks",  "South Indian",  "Street Food",  "Thai",  "Wraps"];
?>
@foreach($cuisines as $cuisine)
    <option value="{{ $cuisine }}" {{ $restaurant->cuisines?array_search($cuisine, json_decode($restaurant->cuisines,true))>-1?'selected':'':'' }}>{{ $cuisine }}</option>
@endforeach
