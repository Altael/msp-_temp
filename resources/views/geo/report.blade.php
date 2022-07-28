@extends('layouts.app')

@section('content')

    <div class="appGeoReport">
        <div class="appGeoReport-count">{{ __('Overall') }}: {{ $data['users_count'] }}</div>
        <div class="appGeoReport-count">{{ __('Without area') }}: {{ $data['users_without_area_count'] }}</div>
        <div class="appGeoReport-count">{{ __('Without city') }}: {{ $data['users_without_city_count'] }}</div>
        @foreach($data['structure'] as $sector)
            <input type="checkbox" id="appGeoReport-levelSector{{ $sector['id'] }}" class="appGeoReport-levelCheck dhrtCheckbox-noView">
            <label for="appGeoReport-levelSector{{ $sector['id'] }}" class="appGeoReport-levelWrap appGeoReport-levelSector">
                <div class="appGeoReport-level">
                    <div class="appGeoReport-levelName">
                        <div class="appIcons-grid appGeoReport-iconGrid"></div>
                        <div class="appGeoReport-levelNameText">
                        <div>{{ $sector['name'] }}</div>
                        <div class="appGeoReport-levelNameTextTitle">{{ __('Sector') }}</div>
                        </div>
                    </div>
                    <div class="appGeoReport-levelInfo">
                        <div class="appGeoReport-listName">{{__('Acaryas')}}</div>
                        <div class="appGeoReport-listValue appGeoReport-listValueAcarya">
                            <div class="appGEO-detailContentStaffAvatarWrap">
                                @foreach($sector['acaryas'] as $acarya)
                                    <avatar class="appGEO-detailContentStaffAvatar appAvatar" src="{{ $acarya->profile->image }}" title="{{ $acarya->name }}"></avatar>
                                @endforeach
                            </div>

                        </div>
                        <div class="appGeoReport-listName">{{__('Regions')}}</div>
                        <div class="appGeoReport-listValue">{{ $sector['regionCount'] }}</div>
                        <div class="appGeoReport-listName">{{__('Dioceses')}}</div>
                        <div class="appGeoReport-listValue">{{ $sector['dioceseCount'] }}</div>
                        <div class="appGeoReport-listName">{{__('Districts')}}</div>
                        <div class="appGeoReport-listValue">{{ $sector['districtCount'] }}</div>
                        <div class="appGeoReport-listName">{{__('Areas')}}</div>
                        <div class="appGeoReport-listValue">{{ $sector['areaCount'] }}</div>
                        <div class="appGeoReport-listName">{{__('Units')}}</div>
                        <div class="appGeoReport-listValue">{{ $sector['unitCount'] }}</div>
                        <div class="appGeoReport-listName">{{__('Participants')}}</div>
                        <div class="appGeoReport-listValue">{{ $sector['users'] }}</div>
                    </div>
                </div>

                @foreach($sector['regions'] as $region)
                    <input type="checkbox" id="appGeoReport-levelRegion{{ $region['id'] }}" class="appGeoReport-levelCheck dhrtCheckbox-noView">
                    <label for="appGeoReport-levelRegion{{ $region['id'] }}" class="appGeoReport-levelWrap appGeoReport-levelRegion">
                        <div class="appGeoReport-level">
                            <div class="appGeoReport-levelName">
                                <div class="appIcons-grid appGeoReport-iconGrid"></div>
                                <div class="appGeoReport-levelNameText">
                                    <div>{{ $region['name'] }}</div>
                                    <div class="appGeoReport-levelNameTextTitle">{{ __('Region') }}</div>
                                </div>
                            </div>
                            <div class="appGeoReport-levelInfo">
                                <div class="appGeoReport-listName">{{__('Acaryas')}}</div>
                                <div class="appGeoReport-listValue appGeoReport-listValueAcarya">
                                    <div class="appGEO-detailContentStaffAvatarWrap">
                                        @foreach($region['acaryas'] as $acarya)
                                            <avatar class="appGEO-detailContentStaffAvatar appAvatar" src="{{ $acarya->profile->image }}" title="{{ $acarya->name }}"></avatar>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="appGeoReport-listName">{{__('Dioceses')}}</div>
                                <div class="appGeoReport-listValue">{{ $region['dioceseCount'] }}</div>
                                <div class="appGeoReport-listName">{{__('Districts')}}</div>
                                <div class="appGeoReport-listValue">{{ $region['districtCount'] }}</div>
                                <div class="appGeoReport-listName">{{__('Areas')}}</div>
                                <div class="appGeoReport-listValue">{{ $region['areaCount'] }}</div>
                                <div class="appGeoReport-listName">{{__('Units')}}</div>
                                <div class="appGeoReport-listValue">{{ $region['unitCount'] }}</div>
                                <div class="appGeoReport-listName">{{__('Participants')}}</div>
                                <div class="appGeoReport-listValue">{{ $region['users'] }}</div>
                            </div>
                        </div>

                        @foreach($region['dioceses'] as $diocese)
                            <input type="checkbox" id="appGeoReport-levelDiocese{{ $diocese['id'] }}" class="appGeoReport-levelCheck dhrtCheckbox-noView">
                            <label for="appGeoReport-levelDiocese{{ $diocese['id'] }}" class="appGeoReport-levelWrap appGeoReport-levelDiocese">
                                <div class="appGeoReport-level">
                                    <div class="appGeoReport-levelName">
                                        <div class="appIcons-grid appGeoReport-iconGrid"></div>
                                        <div class="appGeoReport-levelNameText">
                                            <div>{{ $diocese['name'] }}</div>
                                            <div class="appGeoReport-levelNameTextTitle">{{ __('Diocese') }}</div>
                                        </div>
                                    </div>
                                    <div class="appGeoReport-levelInfo">
                                            <div class="appGeoReport-listName">{{__('Acaryas')}}</div>
                                            <div class="appGeoReport-listValue appGeoReport-listValueAcarya">
                                                <div class="appGEO-detailContentStaffAvatarWrap">
                                                    @foreach($diocese['acaryas'] as $acarya)
                                                        <avatar class="appGEO-detailContentStaffAvatar appAvatar" src="{{ $acarya->profile->image }}" title="{{ $acarya->name }}"></avatar>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="appGeoReport-listName">{{__('Diocese')}}</div>
                                            <div class="appGeoReport-listValue">{{ $diocese['districtCount'] }}</div>
                                            <div class="appGeoReport-listName">{{__('Areas')}}</div>
                                            <div class="appGeoReport-listValue">{{ $diocese['areaCount'] }}</div>
                                            <div class="appGeoReport-listName">{{__('Units')}}</div>
                                            <div class="appGeoReport-listValue">{{ $diocese['unitCount'] }}</div>
                                            <div class="appGeoReport-listName">{{__('Participants')}}</div>
                                            <div class="appGeoReport-listValue">{{ $diocese['users'] }}</div>
                                    </div>
                                </div>

                                @foreach($diocese['districts'] as $district)
                                    <input type="checkbox" id="appGeoReport-levelDistrict{{ $district['id'] }}" class="appGeoReport-levelCheck dhrtCheckbox-noView">
                                    <label for="appGeoReport-levelDistrict{{ $district['id'] }}" class="appGeoReport-levelWrap appGeoReport-levelDistrict">
                                        <div class="appGeoReport-level">
                                            <div class="appGeoReport-levelName">
                                                <div class="appIcons-grid appGeoReport-iconGrid"></div>
                                                <div class="appGeoReport-levelNameText">
                                                    <div>{{ $district['name'] }}</div>
                                                    <div class="appGeoReport-levelNameTextTitle">{{ __('District') }}</div>
                                                </div>
                                            </div>
                                            <div class="appGeoReport-levelInfo">
                                                    <div class="appGeoReport-listName">{{__('Acaryas')}}</div>
                                                    <div class="appGeoReport-listValue appGeoReport-listValueAcarya">
                                                        <div class="appGEO-detailContentStaffAvatarWrap">
                                                            @foreach($district['acaryas'] as $acarya)
                                                                <avatar class="appGEO-detailContentStaffAvatar appAvatar" src="{{ $acarya->profile->image }}" title="{{ $acarya->name }}"></avatar>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="appGeoReport-listName">{{__('Areas')}}</div>
                                                    <div class="appGeoReport-listValue">{{ $district['areaCount'] }}</div>
                                                    <div class="appGeoReport-listName">{{__('Units')}}</div>
                                                    <div class="appGeoReport-listValue">{{ $district['unitCount'] }}</div>
                                                    <div class="appGeoReport-listName">{{__('Participants')}}</div>
                                                    <div class="appGeoReport-listValue">{{ $district['users'] }}</div>
                                            </div>
                                        </div>

                                        @foreach($district['areas'] as $area)
                                            <input type="checkbox" id="appGeoReport-levelArea{{ $area['id'] }}" class="appGeoReport-levelCheck dhrtCheckbox-noView">
                                            <label for="appGeoReport-levelArea{{ $area['id'] }}" class="appGeoReport-levelWrap appGeoReport-levelArea">
                                                <div class="appGeoReport-level">
                                                    <div class="appGeoReport-levelName">
                                                        <div class="appIcons-grid appGeoReport-iconGrid"></div>
                                                        <div class="appGeoReport-levelNameText">
                                                            <div>{{ $area['name'] }}</div>
                                                            <div class="appGeoReport-levelNameTextTitle">{{ __('Area') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="appGeoReport-levelInfo">
                                                        <div class="appGeoReport-listName">{{__('Acaryas')}}</div>
                                                        <div class="appGeoReport-listValue appGeoReport-listValueAcarya">
                                                            <div class="appGEO-detailContentStaffAvatarWrap">
                                                                @foreach($area['acaryas'] as $acarya)
                                                                    <avatar class="appGEO-detailContentStaffAvatar appAvatar" src="{{ $acarya->profile->image }}" title="{{ $acarya->name }}"></avatar>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="appGeoReport-listName">{{__('Units')}}</div>
                                                        <div class="appGeoReport-listValue">{{ $area['unitCount'] }}</div>
                                                        <div class="appGeoReport-listName">{{__('Participants')}}</div>
                                                        <div class="appGeoReport-listValue">{{ $area['users'] }}</div>
                                                    </div>
                                                </div>

                                                @foreach($area['units'] as $unit)
                                                    <input type="checkbox" id="appGeoReport-levelUnit{{ $unit['id'] }}" class="appGeoReport-levelCheck dhrtCheckbox-noView">
                                                    <label for="appGeoReport-levelUnit{{ $unit['id'] }}" class="appGeoReport-levelWrap appGeoReport-levelUnit">
                                                        <div class="appGeoReport-level">
                                                            <div class="appGeoReport-levelName">
                                                                <div class="appIcons-grid appGeoReport-iconGrid"></div>
                                                                <div class="appGeoReport-levelNameText">
                                                                    <div>{{ $unit['name'] }}</div>
                                                                    <div class="appGeoReport-levelNameTextTitle">{{ __('Unit') }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="appGeoReport-levelInfo">
                                                                <div class="appGeoReport-listName">{{__('Acaryas')}}</div>
                                                                <div class="appGeoReport-listValue appGeoReport-listValueAcarya">
                                                                    <div class="appGEO-detailContentStaffAvatarWrap">
                                                                        @foreach($unit['acaryas'] as $acarya)
                                                                            <avatar class="appGEO-detailContentStaffAvatar appAvatar" src="{{ $acarya->profile->image }}" title="{{ $acarya->name }}"></avatar>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="appGeoReport-listName">{{__('Participants')}}</div>
                                                                <div class="appGeoReport-listValue">{{ $unit['users'] }}</div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </label>
                                        @endforeach
                                    </label>
                                @endforeach
                            </label>
                        @endforeach
                    </label>
                @endforeach
            </label>
        @endforeach
    </div>
@endsection
