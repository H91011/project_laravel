$(document).ready(function() {
    $('select').material_select();
});
$(document).ready(function() {
    $('ul.tabs').tabs();
});

const statusCode = {
    404: function() {
        Materialize.toast('Status: 404', 2000)
    },
    200: function() {
        Materialize.toast('Status: 200', 2000)
    },
    201: function() {
        Materialize.toast('Status: 201', 2000)
    },
    204: function() {
        Materialize.toast('Status: 204', 2000)
    }
}

function createData(inputs, formPrefix) {
    const data = {}

    for (var i = inputs.length; i--;) {
        data[inputs[i]] = document.getElementById(formPrefix + inputs[i]).value
    }

    if (formPrefix === "company_update_" || formPrefix === "person_update_") {
        const select = document.getElementById(formPrefix + "select")
        data.old = select.options[select.selectedIndex].value
        select.options[select.selectedIndex].value = data.name
        select.options[select.selectedIndex].innerText = data.name
    }

    if (data.internet_address && data.internet_address[data.internet_address.length - 1] !== "/") {
        data.internet_address += "/"
    }
    console.log(data);
    return data
}

function checkData(data) {
    const keys = Object.keys(data)
    for (var i = keys.length; i--;) {
        if (!data[keys[i]]) {
            return false
        }
    }
    return true
}

function warning() {
    alert('empty field !!')
}

function selectChange() {
    const selected = this.options[this.selectedIndex].value
    if (this.formPrefix === 'company') {
        sendReqest('GET', '/api/get/company/' + selected, ['name', 'internet_address'], 'company_update_')
    } else if (this.formPrefix === 'person') {
        sendReqest('GET', '/api/get/person/' + selected, [
                'company_name',
                'name',
                'last_name',
                'title',
                'email',
                'phone_number'
            ],
            'person_update_')
    } else if (this.formPrefix === 'company_address') {
        sendReqest('GET', '/api/list/address', ['address_select_api'], 'address')
    }
}

function fillElems(data) {

    if (this.formPrefix === 'company' || this.formPrefix === 'person' || this.formPrefix === 'address' || this.formPrefix === 'company_address') {
        for (var j = this.elems.length; j--;) {
            const selectelem = document.getElementById(this.elems[j])
            selectelem.innerHTML = ""
            const op = document.createElement("option")
            op.value = ""
            op.setAttribute("disabled", "");
            op.setAttribute("selected", "");
            op.innerHTML = "Select a " + this.formPrefix
            selectelem.add(op)

            if (this.formPrefix === 'company' || this.formPrefix === 'company_address') {
                selectelem.formPrefix = this.formPrefix
                for (var i = data.length; i--;) {
                    const op = document.createElement("option")
                    const {
                        name
                    } = data[i]
                    op.value = name
                    op.innerHTML = name
                    selectelem.add(op)
                }
                selectelem.onchange = selectChange
            } else if (this.formPrefix === 'person') {
                selectelem.formPrefix = this.formPrefix
                for (var i = data.length; i--;) {
                    const op = document.createElement("option")
                    const {
                        email,
                        name,
                        last_name
                    } = data[i]
                    op.value = email
                    op.innerHTML = `${email}-${name} ${last_name}`
                    selectelem.add(op)
                }
                selectelem.onchange = selectChange
            } else if (this.formPrefix === 'address') {
                selectelem.formPrefix = this.formPrefix
                for (var i = data.length; i--;) {
                    const op = document.createElement("option")
                    const {
                        lng,
                        lat
                    } = data[i]
                    op.value = `${lat},${lng}`
                    op.innerHTML = `lat:${lat} lng:${lng}`
                    selectelem.add(op)
                }
            }

        }
        $('select').material_select();
    } else {
        const labels = document.getElementsByClassName("l_update")
        for (var i = labels.length; i--;) {
            labels[i].classList.add("active")
        }
        for (var i = this.elems.length; i--;) {
            const elem = document.getElementById(this.formPrefix + this.elems[i])
            if (this.formPrefix + this.elems[i] === 'person_update_company_name') {
                const options = elem.options
                for (var j = options.length; j--;) {
                    if (data[0][this.elems[i]] === options[j].value) {
                        console.log(options[j].value, data[0][this.elems[i]]);
                        elem.selectedIndex = j
                        $('#person_update_company_name').material_select();
                    }
                }
            } else {
                elem.value = data[0][this.elems[i]]
            }
        }
    }
}

function sendReqest(type, url, elems, formPrefix) {
    switch (type) {
        case 'POST':
            const data = createData(elems, formPrefix)
            const checkResult = checkData(data)
            if (checkResult) {
                $.ajax({
                        type,
                        url,
                        data,
                        statusCode
                    })
                    .fail(function() {
                        // if posting your form failed
                        alert("Posting failed.");
                    });
            } else {
                warning()
            }
            break;
        case 'GET':
            $.ajax({
                    type,
                    url,
                    formPrefix,
                    elems,
                    success: fillElems
                })
                .fail(function() {
                    // if posting your form failed
                    alert("Posting failed.");
                });
        case 'PUT':
            return 0
        case 'DELETE':
            return 0
        default:
    }

}

function SetFunctions() {
    const btn = document.getElementById("add_company")
    btn.onclick = () => {
        sendReqest('POST', '/api/add/company', ['name', 'internet_address'], "company_")
    }

    const btn1 = document.getElementById("update_company_tab")
    btn1.onclick = () => {
        sendReqest('GET', '/api/list/company', ['company_update_select'], 'company')
    }


    const btn2 = document.getElementById("update_company")
    btn2.onclick = () => {
        const select = document.getElementById("company_update_select")
        const index = select.selectedIndex
        if (index) {
            sendReqest('POST', '/api/update/company', ['name', 'internet_address'], "company_update_")
            sendReqest('GET', '/api/list/company', ['company_update_select'], 'company')
        } else {
            alert("Please select company")
        }
    }

    const btn3 = document.getElementById("add_person")
    btn3.onclick = () => {
        sendReqest('POST', '/api/add/person', ['name', 'last_name', 'title', 'email', 'phone_number', 'company_name'], 'person_')
        sendReqest('GET', '/api/list/person', ['person_update_select'], 'person')
    }

    const btn4 = document.getElementById("person")
    btn4.onclick = () => {
        sendReqest('GET', '/api/list/company', ['person_company_name', 'person_update_company_name'], 'company')
        sendReqest('GET', '/api/list/person', ['person_update_select'], 'person')
    }

    const btn5 = document.getElementById("update_person")
    btn5.onclick = () => {
        const index = document.getElementById("person_update_select").selectedIndex
        if (index) {
            sendReqest('POST', '/api/update/person', ['name', 'last_name', 'title', 'email', 'phone_number', 'company_name'], "person_update_")
            sendReqest('GET', '/api/list/person', ['person_update_select'], 'person')

        } else {
            alert("Please select person")
        }
    }

    const btn6 = document.getElementById("delete_company_tab")
    btn6.onclick = () => {
        sendReqest('GET', '/api/list/company', ['company_delete_name'], 'company')
    }

    const btn7 = document.getElementById("delete_person_tab")
    btn7.onclick = () => {
        sendReqest('GET', '/api/list/person', ['person_delete_email'], 'person')
    }

    const btn8 = document.getElementById("delete_company")
    btn8.onclick = () => {
        sendReqest('POST', '/api/delete/company', ['name'], "company_delete_")
        sendReqest('GET', '/api/list/company', ['company_delete_name'], 'company')
    }

    const btn9 = document.getElementById("delete_person")
    btn9.onclick = () => {
        sendReqest('POST', '/api/delete/person', ['email'], "person_delete_")
        sendReqest('GET', '/api/list/person', ['person_delete_email'], 'person')
    }

    const btn10 = document.getElementById("update_person_tab")
    btn10.onclick = () => {
        sendReqest('GET', '/api/list/person', ['person_update_select'], 'person')
    }

    const btn11 = document.getElementById("update_company_tab")
    btn11.onclick = () => {
        sendReqest('GET', '/api/list/company', ['company_update_select'], 'company')
    }

    const btn12 = document.getElementById("api")
    btn12.onclick = () => {
        sendReqest('GET', '/api/list/company', ['company_select_api'], 'company_address')
    }

    const btn13 = document.getElementById("address")
    btn13.onclick = () => {
        sendReqest('GET', '/api/list/company', ['company_address_company_name'], 'company')
    }

    const btn14 = document.getElementById("add_address")
    btn14.onclick = () => {
        sendReqest('POST', '/api/add/address', ['company_name', 'lat', 'lng'], 'company_address_')
    }

    const btn15 = document.getElementById("get_result")
    btn15.onclick = () => {
        var type = ''
        const checkboxes = document.getElementsByClassName("api_field")
        for (var i = checkboxes.length; i--;) {
            if (checkboxes[i].checked) {
                type += checkboxes[i].attributes["data"].value + ","
            }
        }
        if (type) {
            type = type.substring(0, type.length - 1);
        }
        const latlon = document.getElementById("address_select_api").value.split(',')
        console.log(latlon, type);
        var ibbMAP = new SehirHaritasiAPI({
            mapFrame: "mapFrame",
            apiKey: "6fe5f255598c466eba0b4e4a7b87328b"
        }, function() {
            ibbMAP.Nearby.Open({
                lat: parseFloat(latlng[0]),
                lon: parseFloat(latlng[1]),
                type,
                distance: 300
            }).then((as)=> {
              console.log(as);

            });
        });

    }

    const btn16 = document.getElementById("thumbnail_company_tab")
    btn16.onclick = () => {
        sendReqest('GET', '/api/list/company', ['company_thumbnail_select'], 'company')
    }

    const btn17 = document.getElementById("get_thumbnail")
    btn17.onclick = () => {
        const val = document.getElementById("company_thumbnail_select").value
        sendReqest('GET', '/api/saveThumbnail/company/' + val, [], 'company')

        const img = document.getElementById("thumbnailImage");

        $.ajax({
            type: 'GET',
            crossDomain: true,
            url: 'http://localhost:3000/base64',
            success: function(response) {
                img.src = "data:image/png;base64," + response.base64
            }
        })

    }

}

var currentMarker = null

function LoadMap() {
    var mymap = L.map('mapid').setView([41.021835, 28.990699], 10);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        minZoom: 12,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        zoomControl: true
    }).addTo(mymap);
    mymap.zoomControl.setPosition('bottomright');
    mymap.on('click', function(e) {
        if (currentMarker) {
            mymap.removeLayer(currentMarker);
        }
        console.log("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
        document.getElementById("company_address_lat").value = e.latlng.lat
        document.getElementById("company_address_lng").value = e.latlng.lng
        const labels = document.getElementsByClassName("l_address")
        for (var i = labels.length; i--;) {
            labels[i].classList.add("active")
        }
        var marker = new L.marker(e.latlng).addTo(mymap);
        currentMarker = marker

    });
}

SetFunctions()
LoadMap()
