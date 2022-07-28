<template>
    <div class="mfe" v-if="$root.user_info && course">
        <div class="mfe-welcome">
            <span>{{ __('Welcome') + ', ' }}</span>
            <span class="name">{{ $root.user_info.first_name }}</span>
        </div>
        <div class="mfe-video mfe-videoWelcome">
            <div class="mfe-videoSource iframeResponsive">
<!--                <iframe src="https://drive.google.com/file/d/1R400VLpZU-X_3bp4F6h9Ss14xkrsvWoW/preview" width="653" height="368" allow="autoplay"></iframe>-->
<!--                <iframe src="https://drive.google.com/uc?export=view&id=1R400VLpZU-X_3bp4F6h9Ss14xkrsvWoW#t=4" width="653" height="368" allow="autoplay"></iframe>-->
                <iframe src="https://drive.google.com/uc?export=view&id=1GvphUkBxGmMA0nQpEoSuQtkTuZpR36rU#t=4" width="653" height="368" allow="autoplay"></iframe>
                <div class="mfe-videoSourceEnable" @click="openIntro()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="88" height="88" viewBox="0 0 88 88">
                        <g id="Сгруппировать_252" transform="translate(-425 -4377)">
                            <circle id="Эллипс_12" cx="44" cy="44" r="44" transform="translate(425 4377)" fill="#fff"/>
                            <path id="Многоугольник_1" d="M11.623,2.822a2,2,0,0,1,3.421,0l9.783,16.141A2,2,0,0,1,23.116,22H3.551a2,2,0,0,1-1.71-3.037Z" transform="translate(483.333 4407.333) rotate(90)"/>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="mfe-videoTitle">О продвинутой медитации</div>
        </div>
        <div class="mfe-path">
            <div class="mfe-pathTitle">Путь духовного искателя</div>
            <div class="mfe-pathStages">
                <div class="mfe-pathStage stage1" :class="{'checked': $root.user_info.meditation_hours >= 100}" @click="openMeditationModal">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="55.234" height="64.197" viewBox="0 0 55.234 64.197">
                            <g id="Сгруппировать_279" transform="translate(-1934.183 -1041.936)">
                                <g id="Сгруппировать_282">
                                    <g id="Сгруппировать_279-2">
                                        <path id="Контур_199" d="M1961.8,1100.9a27.557,27.557,0,0,1-14.44-4.071l1.047-1.7a25.631,25.631,0,0,0,37.692-29.976q-.279-.831-.611-1.637l1.848-.764c.239.58.46,1.169.659,1.767A27.635,27.635,0,0,1,1961.8,1100.9Z" fill="#ff6d35"/>
                                    </g>
                                    <g id="Сгруппировать_281">
                                        <g id="Сгруппировать_280">
                                            <path id="Контур_200" d="M1957.7,1091.715l.511,1.936-9.538,2.505,3.2,9.33-1.894.647-3.89-11.364Z" fill="#ff6d35"/>
                                        </g>
                                    </g>
                                </g>
                                <g id="Сгруппировать_286">
                                    <g id="Сгруппировать_283">
                                        <path id="Контур_201" d="M1938.108,1087.486a27.62,27.62,0,0,1,40.635-36.01l-1.228,1.578a25.368,25.368,0,0,0-15.715-5.385,25.623,25.623,0,0,0-21.977,38.787Z" fill="#ff6d35"/>
                                    </g>
                                    <g id="Сгруппировать_285">
                                        <g id="Сгруппировать_284">
                                            <path id="Контур_202" d="M1967.9,1055.394l-.29-1.981,9.759-1.417-2.126-9.631,1.955-.43,2.587,11.73Z" fill="#ff6d35"/>
                                        </g>
                                    </g>
                                </g>
                                <g id="Сгруппировать_287">
                                    <path id="Контур_203" d="M1950.036,1080.048h-1.915v-12.695l-3.841,1.41v-1.73l5.457-2.049h.3Z" fill="#ff6d35"/>
                                    <path id="Контур_204" d="M1965.018,1073.654a8.711,8.711,0,0,1-1.143,4.973,4.748,4.748,0,0,1-7.125.036,8.261,8.261,0,0,1-1.195-4.752v-2.543a8.523,8.523,0,0,1,1.143-4.911,4.835,4.835,0,0,1,7.146-.057,8.23,8.23,0,0,1,1.174,4.783Zm-1.906-2.605a7,7,0,0,0-.678-3.527,2.343,2.343,0,0,0-2.153-1.106,2.311,2.311,0,0,0-2.132,1.1,6.824,6.824,0,0,0-.689,3.388v3.048a7.094,7.094,0,0,0,.705,3.588,2.336,2.336,0,0,0,2.137,1.158,2.3,2.3,0,0,0,2.095-1.092,6.82,6.82,0,0,0,.715-3.439Z" fill="#ff6d35"/>
                                    <path id="Контур_205" d="M1976.858,1073.654a8.711,8.711,0,0,1-1.142,4.973,4.748,4.748,0,0,1-7.125.036,8.262,8.262,0,0,1-1.195-4.752v-2.543a8.515,8.515,0,0,1,1.143-4.911,4.836,4.836,0,0,1,7.146-.057,8.223,8.223,0,0,1,1.173,4.783Zm-1.905-2.605a6.984,6.984,0,0,0-.679-3.527,2.34,2.34,0,0,0-2.152-1.106,2.31,2.31,0,0,0-2.132,1.1,6.812,6.812,0,0,0-.689,3.388v3.048a7.1,7.1,0,0,0,.7,3.588,2.336,2.336,0,0,0,2.137,1.158,2.3,2.3,0,0,0,2.1-1.092,6.832,6.832,0,0,0,.715-3.439Z" fill="#ff6d35"/>
                                </g>
                            </g>
                        </svg>
                        <div class="mfe-pathStageCheck" v-if="meditated">
                            &check;
                        </div>
                    </div>
                    <div class="mfe-pathStageDescription">
                        1.&nbsp;Намедитировать 100&nbsp;часов тихой медитации
                    </div>


                </div>
                <div class="mfe-pathStage separator" :class="{'checked': $root.user_info.meditation_hours >= 100}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.884" height="14.94" viewBox="0 0 8.884 14.94">
                            <g id="Сгруппировать_16213" transform="translate(1.414 1.414)">
                                <line id="Линия_2" x2="6.056" y2="6.056" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                                <line id="Линия_3" x1="6.056" y2="6.056" transform="translate(0 6.056)" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="mfe-pathStage stage2" :class="{'checked': course && course.finished}" @click="openInfo()">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="55.574" height="43.018" viewBox="0 0 55.574 43.018">
                            <g id="Сгруппировать_265" transform="translate(-1259.426 -884.34)">
                                <g id="Сгруппировать_264" transform="translate(-5965.404 -6197)">
                                    <g id="Сгруппировать_141">
                                        <g id="Сгруппировать_121" transform="translate(5680.617 5903.438)">
                                            <path id="Контур_125" d="M1595.438,1220.921h-46.876a4.353,4.353,0,0,1-4.349-4.348v-34.321a4.354,4.354,0,0,1,4.349-4.349h46.876a4.354,4.354,0,0,1,4.349,4.349v34.321A4.353,4.353,0,0,1,1595.438,1220.921Zm-46.876-41.018a2.352,2.352,0,0,0-2.349,2.349v34.321a2.351,2.351,0,0,0,2.349,2.348h46.876a2.351,2.351,0,0,0,2.349-2.348v-34.321a2.352,2.352,0,0,0-2.349-2.349Z" fill="#ff6d35"/>
                                        </g>
                                        <g id="Сгруппировать_122" transform="translate(5680.617 5903.438)">
                                            <path id="Контур_126" d="M1564.679,1211.715a2.009,2.009,0,0,1-2-2v-20.831a2,2,0,0,1,3-1.73l17.981,10.415a2,2,0,0,1,0,3.461l-17.982,10.415A1.994,1.994,0,0,1,1564.679,1211.715Zm0-22.834v20.83l17.981-10.415Z" fill="#ff6d35"/>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <div class="mfe-pathStageCheck" v-if="course && course.finished">
                            &check;
                        </div>
                    </div>
                    <div class="mfe-pathStageDescription">
                        2.&nbsp;Посмотреть все&nbsp;видео о&nbsp;духовной инициации
                    </div>

                </div>
                <div class="mfe-pathStage separator" :class="{'checked': course && course.finished}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.884" height="14.94" viewBox="0 0 8.884 14.94">
                            <g id="Сгруппировать_16213" transform="translate(1.414 1.414)">
                                <line id="Линия_2" x2="6.056" y2="6.056" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                                <line id="Линия_3" x1="6.056" y2="6.056" transform="translate(0 6.056)" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="mfe-pathStage stage3" :class="{'checked': course.open_request || course.successfull_call}" @click="openLesson">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="54.363" height="54.596" viewBox="0 0 54.363 54.596">
                            <g id="Сгруппировать_288" transform="translate(-1963.743 -955.049)">
                                <path id="Контур_208" d="M1987.049,982.854h26.709a3.348,3.348,0,0,1,3.348,3.348v13.516a3.348,3.348,0,0,1-3.348,3.349h-.822v4.355a1.192,1.192,0,0,1-2.035.843l-5.2-5.2h-18.653a3.349,3.349,0,0,1-3.349-3.349V986.2A3.348,3.348,0,0,1,1987.049,982.854Z" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <path id="Контур_209" d="M1994.8,956.049h-26.71a3.348,3.348,0,0,0-3.348,3.348v13.516a3.348,3.348,0,0,0,3.348,3.348h.822v4.356a1.193,1.193,0,0,0,2.036.843l5.2-5.2H1994.8a3.348,3.348,0,0,0,3.348-3.348V959.4A3.348,3.348,0,0,0,1994.8,956.049Z" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                            </g>
                        </svg>
                        <div class="mfe-pathStageCheck" v-if="course.open_request || course.successfull_call">
                            &check;
                        </div>
                    </div>
                    <div class="mfe-pathStageDescription">
                        3.&nbsp;Подать заявку на встречу с куратором
                    </div>
                </div>
                <div class="mfe-pathStage separator" :class="{'checked': course.open_request || course.successfull_call}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.884" height="14.94" viewBox="0 0 8.884 14.94">
                            <g id="Сгруппировать_16213" transform="translate(1.414 1.414)">
                                <line id="Линия_2" x2="6.056" y2="6.056" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                                <line id="Линия_3" x1="6.056" y2="6.056" transform="translate(0 6.056)" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="mfe-pathStage stage4" :class="{'checked': course.successfull_call}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="54.363" height="54.596" viewBox="0 0 54.363 54.596">
                            <g id="Сгруппировать_288" transform="translate(-1963.743 -955.049)">
                                <path id="Контур_208" d="M1987.049,982.854h26.709a3.348,3.348,0,0,1,3.348,3.348v13.516a3.348,3.348,0,0,1-3.348,3.349h-.822v4.355a1.192,1.192,0,0,1-2.035.843l-5.2-5.2h-18.653a3.349,3.349,0,0,1-3.349-3.349V986.2A3.348,3.348,0,0,1,1987.049,982.854Z" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <path id="Контур_209" d="M1994.8,956.049h-26.71a3.348,3.348,0,0,0-3.348,3.348v13.516a3.348,3.348,0,0,0,3.348,3.348h.822v4.356a1.193,1.193,0,0,0,2.036.843l5.2-5.2H1994.8a3.348,3.348,0,0,0,3.348-3.348V959.4A3.348,3.348,0,0,0,1994.8,956.049Z" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                            </g>
                        </svg>
                        <div class="mfe-pathStageCheck" v-if="course.succesfull_call">
                            &check;
                        </div>
                    </div>
                    <div class="mfe-pathStageDescription">
                        4.&nbsp;Встреча с куратором
                    </div>
                </div>
                <div class="mfe-pathStage separator" :class="{'checked': course.successfull_call}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.884" height="14.94" viewBox="0 0 8.884 14.94">
                            <g id="Сгруппировать_16213" transform="translate(1.414 1.414)">
                                <line id="Линия_2" x2="6.056" y2="6.056" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                                <line id="Линия_3" x1="6.056" y2="6.056" transform="translate(0 6.056)" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="mfe-pathStage stage5" :class="{'checked': course.initiation_request}" @click="confirmRequest">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="37.641" height="43.018" viewBox="0 0 37.641 43.018">
                            <g id="Сгруппировать_298" data-name="Сгруппировать 298" transform="translate(-32)">
                                <path id="Контур_217" data-name="Контур 217" d="M67.868,9.623a38.092,38.092,0,0,0-3.662-4.189,38.1,38.1,0,0,0-4.189-3.662C57.851.184,56.8,0,56.2,0H35.361A3.365,3.365,0,0,0,32,3.361v36.3a3.365,3.365,0,0,0,3.361,3.361H66.28a3.365,3.365,0,0,0,3.361-3.361V13.443C69.641,12.841,69.457,11.79,67.868,9.623ZM62.3,7.336a36.67,36.67,0,0,1,3.049,3.419H58.886V4.287A36.631,36.631,0,0,1,62.3,7.336Zm4.647,32.321a.681.681,0,0,1-.672.672H35.361a.681.681,0,0,1-.672-.672V3.361a.681.681,0,0,1,.672-.672H56.2V12.1a1.344,1.344,0,0,0,1.344,1.344h9.41Z" transform="translate(0 0)" fill="#ff6d35"/>
                                <path id="Контур_218" data-name="Контур 218" d="M148.165,386.689h-18.82a1.344,1.344,0,1,1,0-2.689h18.82a1.344,1.344,0,1,1,0,2.689Z" transform="translate(-87.934 -351.736)" fill="#ff6d35"/>
                                <path id="Контур_219" data-name="Контур 219" d="M148.165,322.689h-18.82a1.344,1.344,0,1,1,0-2.689h18.82a1.344,1.344,0,1,1,0,2.689Z" transform="translate(-87.934 -293.114)" fill="#ff6d35"/>
                                <path id="Контур_220" data-name="Контур 220" d="M148.165,258.689h-18.82a1.344,1.344,0,1,1,0-2.689h18.82a1.344,1.344,0,1,1,0,2.689Z" transform="translate(-87.934 -234.491)" fill="#ff6d35"/>
                            </g>
                        </svg>



                        <div class="mfe-pathStageCheck" v-if="course.initiation_request">
                            &check;
                        </div>
                    </div>
                    <div class="mfe-pathStageDescription">
                        4.&nbsp;Заявка на личный контакт с&nbsp;ачарьей для&nbsp;получения урока
                    </div>

                </div>
                <div class="mfe-pathStage separator" :class="{'checked': course.initiation_request}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8.884" height="14.94" viewBox="0 0 8.884 14.94">
                            <g id="Сгруппировать_16213" transform="translate(1.414 1.414)">
                                <line id="Линия_2" x2="6.056" y2="6.056" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                                <line id="Линия_3" x1="6.056" y2="6.056" transform="translate(0 6.056)" fill="none" stroke="#ff6d35" stroke-linecap="round" stroke-width="2"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="mfe-pathStage stage6" :class="{'checked': $root.user_info.current_lesson}">
                    <div class="mfe-pathStageIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56.254" height="54.405" viewBox="0 0 56.254 54.405">
                            <g id="Сгруппировать_289" transform="translate(-2046.758 -954.207)">
                                <line id="Линия_27" x2="6.444" y2="23.921" transform="translate(2068.297 957.67)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <circle id="Эллипс_57" cx="3" cy="3" r="3" transform="translate(2065.307 954.707)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_58" cx="3" cy="3" r="3" transform="translate(2096.511 975.812)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_59" cx="3" cy="3" r="3" transform="translate(2089.097 961.087)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_60" cx="3" cy="3" r="3" transform="translate(2089.097 995.902)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_61" cx="3" cy="3" r="3" transform="translate(2061.561 987.337)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_62" cx="3" cy="3" r="3" transform="translate(2074.731 965.444)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_63" cx="3" cy="3" r="3" transform="translate(2075.329 991.533)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_64" cx="3" cy="3" r="3" transform="translate(2071.731 978.555)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_65" cx="3" cy="3" r="3" transform="translate(2052.235 963.464)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_66" cx="3" cy="3" r="3" transform="translate(2047.258 983.018)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <circle id="Эллипс_67" cx="3" cy="3" r="3" transform="translate(2063.948 1002.113)" fill="#ff6d35" stroke="#ff6d35" stroke-width="1"/>
                                <line id="Линия_28" x2="19.572" y2="15.179" transform="translate(2055.168 966.413)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <line id="Линия_29" y1="4.264" x2="24.403" transform="translate(2050.338 981.591)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <line id="Линия_30" x1="7.79" y2="23.516" transform="translate(2066.95 981.591)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <line id="Линия_31" y1="2.78" x2="24.771" transform="translate(2074.741 978.812)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <line id="Линия_32" x2="17.538" y2="17.492" transform="translate(2074.741 981.591)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                                <line id="Линия_33" y1="17.673" x2="17.356" transform="translate(2074.741 963.918)" fill="none" stroke="#ff6d35" stroke-miterlimit="10" stroke-width="2"/>
                            </g>
                        </svg>
                        <div class="mfe-pathStageCheck" v-if="$root.user_info.current_lesson">
                            &check;
                        </div>
                    </div>
                    <div class="mfe-pathStageDescription">
                        5.&nbsp;Личный контакт с&nbsp;ачарьей для&nbsp;получения урока
                    </div>

                </div>
            </div>
        </div>
        <div class="mfe-hours">
            <div class="mfe-hoursTitle">Безмолвная медитация</div>
            <div class="mfe-hoursBody">
                <div class="mfe-hoursQuestion" v-if="$root.user_info.meditation_hours < 100" >
                    <div class="mfe-hoursQuestionText">Я намедитировал как минимум 100 часов безмолвной медитации</div>
                    <div class="mfe-hoursQuestionButtons">
                        <div class="mfe-hoursQuestionBtn yes" @click="confirm100hours">{{ __('Yes') }}</div>
                        <div class="mfe-hoursQuestionBtn no">{{ __('No') }}</div>
                    </div>
                </div>
                <div class="mfe-hoursText" v-else>
                    100 часов безмолвной медитации: <span class="ok">&check;</span>
                </div>
            </div>
        </div>
        <input type="checkbox" id="mfe-courseViewCheckbox">
        <div class="mfe-course" v-if="course">
            <div class="mfe-courseTitle">
                <span class="mfe-courseTitleLeft">
                    Видео о духовном пути
                </span>
                <label class="mfe-courseViewBtn" for="mfe-courseViewCheckbox">
                    <span class="mfe-courseMore">Еще ↗</span>
                    <span class="mfe-courseLess">Свернуть ↘</span>
                </label>
            </div>

            <div class="mfe-courseStagesWrapper">                    <div class="dhrtHorizontalScroll-wrapperInner">

            <div class="dhrtHorizontalScroll-wrapperOuter">
                        <div class="mfe-courseStages">
                            <div class="mfe-courseStage" v-for="(stage_info, index) in course.stages_info">
                                <div :class="{'checked': stage_info.finished, 'current': !course.stages[index]}">
                                    <div class="mfe-video">
                                        <div class="mfe-videoSource iframeResponsive">
                                            <iframe :src="course.stages[index].videos[0]" :key="course.stages[index].videos[0] + '&output=embed'" ref="video" allow="autoplay"></iframe>
                                            <div class="mfe-videoSourceEnable" @click="openInfo(index)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="88" height="88" viewBox="0 0 88 88">
                                                    <g id="Сгруппировать_252" transform="translate(-425 -4377)">
                                                        <circle id="Эллипс_12" cx="44" cy="44" r="44" transform="translate(425 4377)" fill="#fff"/>
                                                        <path id="Многоугольник_1" d="M11.623,2.822a2,2,0,0,1,3.421,0l9.783,16.141A2,2,0,0,1,23.116,22H3.551a2,2,0,0,1-1.71-3.037Z" transform="translate(483.333 4407.333) rotate(90)"/>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="mfe-videoSourceDisable" @click="openMeditationModal()" v-if="!meditated || !((index === 0) || course.stages_info[index - 1].finished || $root.user_info.current_lesson)"></div>
                                            <div class="mfe-videoChecked" v-if="stage_info.finished">&check;</div>
                                            <div class="mfe-videoNumber">{{ (index+1) + ' ' + __('of') + ' ' + course.stages_info.length }} </div>
                                        </div>
                                        <div class="mfe-videoTitle">{{ course.stages[index].name }}</div>



                                    </div>
<!--
                                    <div class="mfe-courseStageCheck done" v-if="!stage_info.finished" @click="closeStage(stage_info.id)">
                                        &check;
                                    </div>
-->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mfe-lesson" @click="openLesson()" v-if="!$root.user_info.current_lesson && !$root.user_info.call_requests.includes('adequate-1') && !course.open_request && !course.successfull_call">
            <div class="mfe-lessonText">
                <div>Подать заявку</div>
                <div>Готов к встрече с куратором</div>
            </div>
            <div class="mfe-lessonArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.743" height="31.243" viewBox="0 0 17.743 31.243">
                    <g id="Сгруппировать_16213" transform="translate(2.121 2.121)">
                        <line id="Линия_2" x2="13.5" y2="13.5" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                        <line id="Линия_3" x1="13.5" y2="13.5" transform="translate(0 13.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="mfe-lesson" @click="confirmRequest()" v-if="!$root.user_info.current_lesson && !$root.user_info.call_requests.includes('adequate-1') && !course.open_request && course.successfull_call">
            <div class="mfe-lessonText">
                <div>Подать заявку на личный урок</div>
            </div>
            <div class="mfe-lessonArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.743" height="31.243" viewBox="0 0 17.743 31.243">
                    <g id="Сгруппировать_16213" transform="translate(2.121 2.121)">
                        <line id="Линия_2" x2="13.5" y2="13.5" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                        <line id="Линия_3" x1="13.5" y2="13.5" transform="translate(0 13.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                    </g>
                </svg>
            </div>
        </div>

        <div class="infoBlockModal withVideo mfeVideo" v-if="info_modal">
            <div class="infoBlockModal-back"></div>
            <div class="infoBlockModal-content">
                <div class="infoBlockModal-layerClose" @click="info_modal = false"></div>

                <div class="infoBlockModal-tools">
                    <div class="infoBlockModal-toolsHead">
                        <template v-if="info_type === 'video'">
                            {{ course.stages[info_index].name }}
                        </template>
                        <template v-else-if="info_type === 'intro'">
                            О духовном пути
                        </template>
                        <template v-else>
                            {{ __('Leave call request') }}
                        </template>
                    </div>
                    <div class="infoBlockModal-toolsClose" @click="info_modal = false">
                        <div class="msppIcons msppIcons-x"></div>
                    </div>
                </div>
                <div class="infoBlockModal-body">
                    <template v-if="info_type === 'intro'">
                        <div class="iframeResponsive mfeVideo-src">
                            <iframe src="https://drive.google.com/file/d/1R400VLpZU-X_3bp4F6h9Ss14xkrsvWoW/preview"></iframe>
                            <div class="mfeVideo-popup"></div>
                        </div>

                    </template>
                    <template v-if="info_type === 'video'">
                        <div class="iframeResponsive mfeVideo-src">
                            <iframe :src="info_src" allowfullscreen="false" webkitallowfullscreen="false" mozallowfullscreen="false"></iframe>
                            <div class="mfeVideo-popup"></div>
                        </div>

                        <div class="mfeVideo-tools">
                            <div class="mfeVideo-toolsBtn prev" @click="info_index--" :class="{'disabled': info_index === 0}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11.842" height="19.442" viewBox="0 0 11.842 19.442">
                                    <g id="Сгруппировать_16213" data-name="Сгруппировать 16213" transform="translate(2.121 2.121)">
                                        <line id="Линия_2" data-name="Линия 2" x1="7.599" y1="7.599" transform="translate(0 7.599)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                                        <line id="Линия_3" data-name="Линия 3" y1="7.599" x2="7.599" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                                    </g>
                                </svg>
                                &nbsp;Предыдущее&nbsp;видео
                            </div>
                            <div class="mfeVideo-toolsBtn index">{{ (info_index+1) + ' ' + __('of') + ' ' + course.stages_info.length }} </div>
                            <div class="mfeVideo-toolsBtn done" v-if="!course.stages_info[info_index].finished && !$root.user_info.current_lesson" @click="closeStage(course.stages_info[info_index].id)">
                                Просмотрено
                            </div>
                            <div v-else class="mfeVideo-toolsBtn next" :class="{'disabled': info_index === (course.stages_info.length - 1)}" @click="info_index++">
                                Следующее&nbsp;видео&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="11.842" height="19.442" viewBox="0 0 11.842 19.442">
                                    <g id="Сгруппировать_16213" data-name="Сгруппировать 16213" transform="translate(2.121 2.121)">
                                        <line id="Линия_2" data-name="Линия 2" x2="7.599" y2="7.599" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                                        <line id="Линия_3" data-name="Линия 3" x1="7.599" y2="7.599" transform="translate(0 7.599)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"/>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </template>
                    <template v-else-if="info_type === 'lesson'">
                        <div class="mfe-infoModal">
                            Чтобы подать заявку на звонок с куратором, посмотрите все видео.
                        </div>
                    </template>
                    <template v-if="info_type === 'meditatio'">
                        <div class="mfe-infoModal">
                            <div class="mfe-hoursQuestionText">Вы намедитировали 100 часов безмолвной медитации?</div>
                            <div class="mfe-hoursQuestionButtons">
                                <div class="mfe-hoursQuestionBtn yes" @click="confirm100hours()">{{ __('Yes') }}</div>
                                <div class="mfe-hoursQuestionBtn no" @click="info_modal = false">{{ __('No') }}</div>
                            </div>
                        </div>
                    </template>
                    <template v-if="info_type === 'conversatio'">
                        <div class="mfe-infoModal">
                            Перед тем как оставить заявку на получение личного урока свяжитесь с куратором.
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            course: null,
            info_modal: false,
            info_index: 0,
            info_type: 'video'
        }
    },

    mounted() {
        this.initializeCourse();
    },

    computed: {
        info_src() {
            return (this.course.stages.length && this.course.stages[this.info_index]) ? this.course.stages[this.info_index].videos[0] : null;
        },

        meditated() {
            return this.$root.user_info.meditation_hours >= 100;
        },

        completion() {

        }
    },

    methods: {
        initializeCourse() {
            let params = {
                course_slug: 'about-spiritual-path'
            };

            this.$root.loading = true;

            axios.post('/start-course', params).then( response => {
                this.course = response.data.course;
                this.$root.loading = false;
            }).catch( e => {
                this.$root.loading = false;
            });
        },

        closeStage(id) {
            let params = {
                stage_id: id
            };

            axios.post('/close-stage', params).then( response => {
                this.initializeCourse();

                //if(this.info_index < (this.course.stages_info.length - 1)) this.info_index++;
            });
        },

        openMeditationModal() {
            if(!this.meditated) {
                this.info_type = 'meditatio';
                this.info_modal = true;
            }
        },

        openInfo(index = null) {
            if(this.$root.user_info.meditation_hours >= 100) {
                this.info_type = 'video';
                this.info_modal = true;

                if(index !== null) this.info_index = JSON.parse(JSON.stringify(index));
                else {
                    let index = this.course.stages_info.findIndex( stage => {
                        return stage.finished === 0;
                    });

                    console.log(index);

                    this.info_index = (index !== -1) ? index : (this.course.stages_info.length - 1);
                }
            } else {
                this.confirm100hours();
            }
        },

        openLesson() {
            if(!this.course.finished){
                this.info_type = 'lesson';
                this.info_modal = true;
            } else {
                window.location.href = "/call-request";
            }
        },

        openIntro() {
            this.info_type = 'intro';
            this.info_modal = true;
        },

        confirm100hours() {
            if(this.$root.user_info.meditation_hours < 100) {
                axios.post('/confirm-100-hours').then( result => {
                    this.$root.user_info.meditation_hours = 100;
                    this.info_modal = false;
                    $('html, body').animate({
                        scrollTop: $(".mfe-course").offset().top
                    }, 1000);
                }).catch( e => {

                });
            }
        },

        confirmRequest() {
            if(this.course.successfull_call) {
                window.location.href = "/user/request";
            } else {
                this.info_type = 'conversatio';
                this.info_modal = true;
            }
        }
    }
}
</script>
