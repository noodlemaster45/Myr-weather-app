<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/6b0fd150ee.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css.css') }}">
    <script type="text/javascript" src="{{ asset('js.js') }}"></script>
    <title>Weathering Heights</title>
</head>
<body>
    <section>
        <video autoplay muted loop id="myVid">
            <source src="{{ asset('videos/'.$weatherData['weather'][0]['main'].'.mp4') }}" type="video/mp4">
            </video>
    </section>
    <div>
      
      <div id="minimize">
        
        <button onclick="hideDiv()" class="button"><i id="buttonIcon" class="fa-solid fa-minimize"></i></button>
       </div>
      <div class="weather box" id="content">
        
        <form action="{{ route('weather') }}" method="get" autocomplete="off">
            @csrf
            </select>
            <div class="autocomplete" style="width:300px;">
                <input id="myInput" type="text" name="city" placeholder="City" value="{{ $oldInput }}">
              </div>
        </form>        
        <h1>Current Weather in {{ $weatherData['name'] }}</h1>
        <p>Description: {{ ucfirst( $weatherData['weather'][0]['description']) }}</p>
        
        <p>Temperature (Celsius): {{ $weatherData['main']['temp'] }}&#8451; - Min: {{ $weatherData['main']['temp_min'] }}&#8451; - Max: {{ $weatherData['main']['temp_max'] }}&#8451;</p>
        
        <p>Temperature (Fahrenheit): {{ $weatherData['main']['temp']*9/5 + 32 }}&#8457; - Min: {{ $weatherData['main']['temp_min']*9/5 + 32 }}&#8457;  - Max: {{ $weatherData['main']['temp_max']*9/5 + 32 }}&#8457;</p>

        <h2>Forecast</h2>

        <div class="container" style="display: grid;grid-template-columns:repeat(5,1fr);gap:10px">
          @for ($i = 0; $i < 5; $i++)
          <div class="column" name="{{  $forecastData['list'][$i]['weather'][0]['main']}}" id = {{ $i }}>
            <p>{{ $forecastData['list'][$i]['dt_txt'] }}</p> 
            <p>{{ ucfirst( $forecastData['list'][$i]['weather'][0]['description']) }}</p>
          </div>
          @endfor
         </div>
        <script>function autocomplete(inp, arr) {
            var currentFocus;
            inp.addEventListener("input", function(e) {
              console.log("1");
              
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                  if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                  }
                }
              });
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                  currentFocus++;
                  addActive(x);
                } else if (e.keyCode == 38) { 
                  currentFocus--;
                  addActive(x);
                } else if (e.keyCode == 13) {
                  e.preventDefault();
                  if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                  }
                  document.forms[0].submit();
                }
            });
            function addActive(x) {
              if (!x) return false;
              removeActive(x);
              if (currentFocus >= x.length) currentFocus = 0;
              if (currentFocus < 0) currentFocus = (x.length - 1);
              x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
              for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
              }
            }
            function closeAllLists(elmnt) {
              var x = document.getElementsByClassName("autocomplete-items");
              for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
              }
            }
          }
          document.addEventListener("click", function (e) {
              closeAllLists(e.target);
          });
        }
        
        autocomplete(document.getElementById("myInput"), @json($cities_list));
        function hideDiv(){
          document.getElementById('content').classList.toggle('hidden');
}

var forecastData = @json($forecastData);
$(".column").each(function () {
        $(this).data("original", $(this).html());
    });
    
    $(".column").hover(
        function () {
            let div = $(this);  
            var imgPath = "{{ asset('icons/') }}" + "/" + div.attr("name")+".png"; 
            let condition = $(this).data("condition") === true;
            let tempCMin = forecastData.list[div.attr('id')].main.temp_min;
            let tempFMin = tempCMin*9/5+32
            if (!$(this).data("toggled")) {
                $(this).html('<img src="'+imgPath+'" width="100%" height="100">  <br>  <p>Min: '+tempCMin+'&#8451; '+tempFMin.toFixed(2)+' &#8457;</p> ').data("toggled", true);
            }
        },
        function () {
            $(this).html($(this).data("original")).data("toggled", false);
        });</script>
    </div>
  </div>
    
</body>
</html>