@extends('layouts.app')

@section('content')
    <input type="text" id="adr" style="width: 300px" placeholder="Add district area">
    <br/>
    <input type="text" id="adr2" style="width: 300px" placeholder="District match">


    <script>
        $(() => {
            let filter = {
                'locality': 'city',
                'administrative_area_level_1': 'region',
                'country': 'country',
            };


            let autocomplete = new google.maps.places.Autocomplete(document.getElementById('adr'), {
                types: ['geocode']
            });

            autocomplete.addListener('place_changed', () => {
                let address = autocomplete.getPlace();

                let type = filter[address.types[0]];

                if (type === undefined) {
                    alert("Only city, region or country accepted!")
                } else {
                    axios.post('/api/district-areas', {
                        districtId: 7,
                        name: address.name,
                        placeId: address.place_id,
                        type: type
                    }).then((response) => {
                        alert('Saved');
                    });
                }
            });

            let match = new google.maps.places.Autocomplete(document.getElementById('adr2'), {
                types: ['geocode']
            });

            match.addListener('place_changed', () => {
                let address = match.getPlace();
                console.log(address);
                let type = filter[address.types[0]];

                if (type === undefined) {
                    alert("Only city, region or country accepted!")
                } else {
                    axios.get('/api/districts/match', {params: {placeId: address.place_id}}).then((response) => {
                        if (response.data.status === 'found') {
                            alert (response.data.district.name);
                        } else {
                            alert ('Not found');
                        }
                    });
                }
            });
        });
    </script>

@endsection

@section('page_js')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?v=3.exp&key=AIzaSyDIievcS0HjHJzNvEhaDWN1mU2pvZ8Fjsw&libraries=places&language=ru"></script>
@append