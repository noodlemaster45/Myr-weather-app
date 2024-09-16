<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/6b0fd150ee.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css.css') }}">
    <title>Weathering Heights</title>
</head>
<body>
    <section>
        <video autoplay muted loop id="myVid">
            <source src="{{ asset('videos/'.$weatherData['weather'][0]['main'].'.mp4') }}" type="video/mp4">
            </video>
    </section>
    <div class="weather">
       
        <form action="{{ route('weather') }}" method="get" autocomplete="off">
            @csrf
            </select>
            <div class="autocomplete" style="width:300px;">
                <input id="myInput" type="text" name="city" placeholder="City" value="{{ $oldInput }}">
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="tempMode" id="tempModeC" value="metric" 
                @if ( $temp == "metric" )
                    checked
                @endif>
                <label class="form-check-label" for="tempModeC">
                 <p>Celsius</p>
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="tempMode" id="tempModeF" value="imperial"
                @if ( $temp == "imperial" )
                    checked
                @endif>
                <label class="form-check-label" for="tempModeF">
                  <p>Fahrenheit</p>
                </label>
              </div>
        </form>        
        <h1>Current Weather in {{ $weatherData['name'] }}</h1>
        <p>Description: {{ ucfirst( $weatherData['weather'][0]['description']) }}</p>
        @if ($temp == "metric")
        <p>Temperature: {{ $weatherData['main']['temp'] }}&#8451; - Min: {{ $weatherData['main']['temp_min'] }}&#8451; - Max: {{ $weatherData['main']['temp_max'] }}&#8451;</p>
        @else
        <p>Temperature: {{ $weatherData['main']['temp'] }}&#8457; - Min: {{ $weatherData['main']['temp_min'] }}&#8457;; - Max: {{ $weatherData['main']['temp_max'] }}&#8457;</p>
        @endif
        <p>Weather type: {{ $weatherData['weather'][0]['main'] }}</p>
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
        
        autocomplete(document.getElementById("myInput"), @json($cities_list));</script>
    </div>
    
</body>
</html>