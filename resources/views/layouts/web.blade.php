<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/home/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/items.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fonts/feather/iconfont.css') }}">
    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>


    

    @yield('page-styles')


</head>
<body class="pace-done vertical-layout vertical-menu-modern content-detached-left-sidebar navbar-floating footer-static menu-expanded">
    <div id="app">
       @include('menu.index')

        <main class="py-4">
            @yield('content')
        </main>

        @include('_partials.footer')
    </div>
</body>
<script>
    $('.search-global').keypress(function (e) {
    if (e.which == 13) {
        $('form#login').submit();
        return false;    //<---- Add this line
    }
    });
</script>

<script>
    /*var data = null;
    $(document).ready(function(){
        var url = "{{ url('/') }}";
        $.ajax({
            type: "GET",
            url: url + '/api/search-productos/ecologico',
            datatype: "json",
            success: function (response) {
                data = response
            }
        });
    });*/

    var data = [
    'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
    'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
    'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
    'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
    'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
    'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
    'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
    'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
    'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
    ];
    

      var searchData = [];
      function searchMe(string) 
      {
        var test = null;
        var url = "{{ url('/') }}";
        url = url + "/api/search-productos/"+string;
        console.log(url);
        $.ajax({
            type: "GET",
            url: url,
            datatype: "json",
            success: function (response) {
                test = jQuery.parseJSON(response);
                //console.log(test);
                $('.list-group').html("<div class='loader'></div>");
                $('.list-group').html("");
                $('.list-group').css('position','absolute');
                $('.list-group').css('top','50px');
                $('.list-group').css('z-index','100');

                if(test != null)
                {
                    test.forEach(element => {
                        console.log(element);
                        (item) => $('.list-group').append(' <a href="#" class="list-group-item list-group-item-action ">'+element.nombre+'</a>')
                    });
                }
                else {
                    $('.list-group').html("<h4>No results found</h4>");
                }
            }
        });
        /*console.log("exito de api");
        searchData = [];
        data.forEach((item) => {


          if (item.match(new RegExp(string, 'i')))
            searchData.push(highlight(item, string));

        });
        $('.list-group').html("<div class='loader'></div>");
        $('.list-group').html("");
        $('.list-group').css('position','absolute');
        $('.list-group').css('top','50px');
        $('.list-group').css('z-index','100');

        if(searchData.length)
        searchData.forEach(
          (item) => $('.list-group').append(' <a href="#" class="list-group-item list-group-item-action ">'+item+'</a>')
        );
        else {
          $('.list-group').html("<h4>No results found</h4>");
        }*/

      }


      function highlight(text, str) {
        return text.replace(new RegExp('(^|)(' + str + ')(|$)','ig'), '$1<b>$2</b>$3');

      }

      $(function() {



        let input;

        //enable or disable the autocomplete

        $('div').on('mouseenter', '.list-group a', function() {
          console.log('mousein');

          $('.list-group a.active').removeClass('active');
          $(this).addClass('active');
        }).on('mouseleave', '.list-group', function() {
          $('.list-group a.active').removeClass('active');

        });


        $(document).on('click', '.list-group a', function() {
          if (input) {
            input.val($(this).text());
          }

          $('.list-group').remove();
        });


        //autocomplete scroll and action on key up
        $('input.my').on('keyup', function(e) {

          //console.log('From key up');
          //console.log(e.which);
          let inLength = $(this).val().length;
          //console.log(e.key);
          //!$('.list-group').length && inLength

          if (((e.key <= 'z' && e.key >= 'a') || (e.key >= 'A' && e.key <= 'Z') && e.key.length === 1) || e.which === 229) {
            if(!$('.list-group').length) {
            $(this).after(
              '<div class="list-group"> </div>'
            );
          }


          setTimeout(searchMe, 1000,$(this).val());


            // $('.list-group').html(
            //
            //   //' <div ><h6 class="text-center text-secondary">Loading...</h6><div class="loader"></div></div> '
            //   ' <a href="#" class="list-group-item list-group-item-action ">Hari </a> <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a> <a href="#" class="list-group-item list-group-item-action">Subesh</a> <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur</a> <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a>  <a href="#" class="list-group-item list-group-item-action ">Vestibulum at eros</a>'
            // );

            let width = parseInt($(this).css('width'));
            if (width > parseInt($('.list-group').css('width'))) {
              console.log('width Changed: ' + width);
              $('.list-group').css('width', width);
            } else {
              console.log(width);
              console.log($('.list-group').css('width'));
            }

            console.log("Added list");
          } else if ($('.list-group').length) {

            //down press
            if (e.which === 40) {
              if (!$('.list-group a.active').length)
                $('.list-group').find('a').eq(0).addClass('active');
              else if ($('.list-group a.active').next().length) {
                $('.list-group a.active').removeClass('active').next().addClass('active');
              } else {
                console.log("Enter");
                $('.list-group a.active').removeClass('active').parent().children('a').eq(0).addClass('active');
                $('.list-group').scrollTop($('.list-group a.active').get(0).offsetTop);
              }

            }
            //up press
            else if (e.which === 38) {
              if (!$('.list-group a.active').length) {
                $('.list-group').find('a').eq(0).addClass('active');
                let text = $('.list-group a.active').text();
                $('label').html(text);
              } else if ($('.list-group a.active').prev().length) {
                $('.list-group a.active').removeClass('active').prev().addClass('active');
                let text = $('.list-group a.active').text();
                $('label').html(text);

              } else {
                $('.list-group').scrollTop($('.list-group a.active').get(0).offsetTop);
                $('.list-group a.active').removeClass('active');

              }


            }
            //enter or right keyPressed()
            else if (e.which === 39 || e.which === 13) {
              if ($('.list-group a.active').length)
                $(this).val($('.list-group a.active').text());

              $('.list-group ').remove();
            }
            //bacspace
            else if (e.which === 8) {
              //alert('Subesh');
              if ($(this).val() === "")
                $('.list-group ').remove();
            } else if (e.which === 27) {
              $('.list-group').remove();
            }

            //set the scroll pos
            if ($('.list-group a.active').prev().length)
              $('.list-group').scrollTop($('.list-group a.active').prev().get(0).offsetTop);

          } else {
            console.log('No list');
          }
        });



        $('input.my').on('focusin', function(e) {
          if ($(this) != input) {
            $('.list-group ').remove();
            input = $(this);
          }

        });



        $(':not(input)').on('click', function() {
          $('.list-group ').remove();
        });









        //keydown operation
        $('input.my').on('keydown', function(e) {
          console.log('From Down');
          console.log(e.which);
          let lastChar = $(this).val().length;
          //tab
          if (e.which === 9) {
            if ($('.list-group').length) {
              if ($('.list-group a.active').length) {
                $(this).val($('.list-group a.active').text());

                $('.list-group ').remove();
              } else {
                $('.list-group').find('a').eq(0).addClass('active');
                e.preventDefault();
                e.stopPropagation();
              }
            }
          }
          //up
          else if (e.which === 38) {
            e.preventDefault();
            e.stopPropagation();
          }

        });



    });
</script>
@yield('page-scripts')
</html>
