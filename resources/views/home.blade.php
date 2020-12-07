<html>

<head>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <style type="text/css">
        html,
        body,
        #mapFrame {
            margin-top:5px;
            width: 100%;
            height: 80%;
            padding: 0;
        }
    </style>
    <script src="http://sehirharitasi.ibb.gov.tr/api/map2.js"></script>

</head>

<body>

    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo center">Which Company? Where?</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
            </ul>
        </div>
    </nav>

    <div class="container">
        <ul id="tabs-swipe-demo" class="tabs mtop" style="text-align: center;">
            <li class="tab col s3" id="company"><a href="#test-swipe-1">Company</a></li>
            <li class="tab col s3" id="person"><a href="#test-swipe-2">Person</a></li>
            <li class="tab col s3" id="address"><a href="#test-swipe-3">Address</a></li>
            <li class="tab col s3" id="api"><a href="#test-swipe-4">Api</a></li>
        </ul>
        <div id="test-swipe-1" class="col s12">

            <ul id="company_iud" class="tabs mtop" style="text-align: center;">
                <li class="tab col s3 " id="insert_company_tab"><a href="#company_insert" class="tfont">Add</a></li>
                <li class="tab col s3 " id="update_company_tab"><a href="#company_update" class="tfont">Update</a></li>
                <li class="tab col s3 " id="delete_company_tab"><a href="#company_delete" class="tfont">Delete</a></li>
                <li class="tab col s3 " id="thumbnail_company_tab"><a href="#company_thumbnail" class="tfont">Thumbnail</a></li>
            </ul>

            <div id="company_insert" class="row col s6">
                <div class="col s6 offset-s3">

                    <div class="row mtop">
                        <div class="input-field col s12">
                            <input id="company_name" type="text" class="validate">
                            <label for="company_name">Company Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="company_internet_address" type="text" class="validate">
                            <label for="company_internet_address">Internet Address Start with : http//* ot https://*</label>
                        </div>
                    </div>

                    <button id="add_company" class="btn waves-effect waves-light right">
                        <i class="material-icons">
                            control_point
                        </i>
                    </button>
                </div>
            </div>
            <div id="company_update" class="row col s6">
                <div class="col s6 offset-s3">

                    <div class="input-field col s12">
                        <select id="company_update_select">
                        </select>
                    </div>
                    <div class="input-field col s12">
                        <input id="company_update_name" type="text" class="validate">
                        <label class="l_update" for="company_update_name">Company Name</label>
                    </div>

                    <div class="input-field col s12">
                        <input id="company_update_internet_address" type="text" class="validate">
                        <label class="l_update" for="company_update_internet_address">Internet Address</label>
                    </div>

                    <button id="update_company" class="btn waves-effect waves-light right">
                        <i class="material-icons">
                            edit
                        </i>
                    </button>

                </div>
            </div>
            <div id="company_delete" class="row col s6">
                <div class="col s6 offset-s3">
                    <select id="company_delete_name">
                    </select>
                    <button id="delete_company" class="btn waves-effect waves-light right" name="action">
                        <i class="material-icons">
                            remove
                        </i>
                    </button>
                </div>
            </div>
            <div id="company_thumbnail" class="row col s6">
                <div class="col s6 offset-s3">
                  <select id="company_thumbnail_select">

                  </select>

                  <button id="get_thumbnail" class="btn waves-effect waves-light right" name="action">
                      <i class="material-icons">
                          get_app
                      </i>
                  </button>

                  <img id="thumbnailImage">


                </div>
            </div>

        </div>
        <div id="test-swipe-2" class="col s12">

            <ul id="person_iud" class="tabs mtop" style="text-align: center;">
                <li class="tab col s3 " id="insert_person_tab"><a href="#person_insert" class="tfont">Add</a></li>
                <li class="tab col s3 " id="update_person_tab"><a href="#person_update" class="tfont">Update</a></li>
                <li class="tab col s3 " id="delete_person_tab"><a href="#person_delete" class="tfont">Delete</a></li>
            </ul>

            <div class="row col s6" id="person_insert">
                <div class="col s6 offset-s3">

                    <div class="input-field col s12">
                        <select id="person_company_name">
                        </select>
                    </div>

                    <div class="row mtop">
                        <div class="input-field col s12">
                            <input id="person_name" type="text" class="validate">
                            <label for="person_name">Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_last_name" type="text" class="validate">
                            <label for="person_last_name">Last Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_title" type="text" class="validate">
                            <label for="person_title">Title</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_email" type="text" class="validate">
                            <label for="person_email">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_phone_number" type="text" class="validate">
                            <label for="person_phone_number">Phone</label>
                        </div>
                    </div>

                    <button id="add_person" class="btn waves-effect waves-light right" name="action">
                        <i class="material-icons">
                            control_point
                        </i>
                    </button>

                </div>
            </div>
            <div class="row col s6" id="person_update">
                <div class="col s6 offset-s3">

                    <div class="input-field col s12">
                        <select id="person_update_select">

                        </select>
                    </div>

                    <div class="input-field col s12">
                        <select id="person_update_company_name">

                        </select>
                    </div>

                    <div class="row mtop">
                        <div class="input-field col s12">
                            <input id="person_update_name" type="text" class="validate">
                            <label class="l_update" for="person_update_name">Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_update_last_name" type="text" class="validate">
                            <label class="l_update" for="person_update_last_name">Last Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_update_title" type="text" class="validate">
                            <label class="l_update" for="person_update_title">Title</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_update_email" type="email" class="validate">
                            <label class="l_update" for="person_update_email">Email</label>
                            <label for="email" data-error="wrong" data-success="right">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="person_update_phone_number" type="text" class="validate">
                            <label class="l_update" for="person_update_phone_number">Phone</label>
                        </div>
                    </div>

                    <button id="update_person" class="btn waves-effect waves-light right" name="action">
                        <i class="material-icons">
                            control_point
                        </i>
                    </button>

                </div>
            </div>
            <div class="row col s6" id="person_delete">

                <div class="col s6 offset-s3">
                    <select id="person_delete_email">
                    </select>
                    <button id="delete_person" class="btn waves-effect waves-light right" name="action">
                        <i class="material-icons">
                            remove
                        </i>
                    </button>
                </div>
            </div>
        </div>
        <div id="test-swipe-3" class="col s12">

            <div class="row col s6">
                <div class="col s6 offset-s3">
                    <select id="company_address_company_name">
                    </select>

                    <div id="mapid"></div>

                    <br>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="company_address_lat" type="text" class="validate">
                            <label class="l_address" for="address_lat">Lat</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="company_address_lng" type="text" class="validate">
                            <label class="l_address" for="address_lng">Lng</label>
                        </div>
                    </div>


                    <button id="add_address" class="btn waves-effect waves-light right" name="action">
                        <i class="material-icons">
                            add
                        </i>
                    </button>

                </div>
            </div>

        </div>
        <div id="test-swipe-4" class="col s12">

            <div class="row col s6">
                <div class="col s6 offset-s3">
                    <select id="company_select_api">
                    </select>

                    <select id="address_select_api">
                    </select>

                    <div class="row s12">
                    <div class="col s3">
                      <input id="ibadethane" class="api_field" data="ibadethane" type="checkbox" />
                      <label class="api_f" for="ibadethane">ibadethane</label>

                      <input id="egitim" class="api_field" data="eğitim" type="checkbox" />
                      <label class="api_f" for="egitim">eğitim</label>
                    </div>


                    <div class="col s3">
                      <input id="saglık" class="api_field" data="sağlık" type="checkbox" />
                      <label class="api_f" for="saglık">sağlık</label>

                      <input id="kamu" class="api_field" data="kamu" type="checkbox" />
                      <label class="api_f" for="kamu">kamu</label>
                    </div>


                    <div class="col s3">
                      <input id="eczane" class="api_field" data="eczane" type="checkbox" />
                      <label class="api_f" for="eczane">eczane</label>

                      <input id="tarihi eser" class="api_field" data="tarihi eser" type="checkbox" />
                      <label class="api_f" for="tarihi eser">tarihi eser</label>
                    </div>


                    <div class="col s3">
                      <input id="banka" class="api_field" data="banka" type="checkbox" />
                      <label class="api_f" for="banka">banka</label>

                      <input id="diger" class="api_field" data="diğer" type="checkbox" />
                      <label class="api_f" for="diger">diğer</label>
                    </div>

                    <div>

                    <button id="get_result" class="btn waves-effect waves-light right" name="action">
                        <i class="material-icons">
                            get_app
                        </i>
                    </button>

                    <div id="harita" style="width:100%; height:100%">
                        <iframe id="mapFrame" src="http://sehirharitasi.ibb.gov.tr/">
                            <p>Tarayıcınız iframe özelliklerini desteklemiyor !</p>
                        </iframe>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <style>
        #mapid {
            height: 300px;
        }

        #get_result{
          margin-top:5px;
        }

        .api_f{
        padding-left: 20px !important;
        }

        .mtop {
            margin-top: 10px;
        }

        .tfont {
            font-size: x-small !important;
        }
    </style>
    <script src="{{ asset('js/home.js')}}"></script>

</body>

</html>
