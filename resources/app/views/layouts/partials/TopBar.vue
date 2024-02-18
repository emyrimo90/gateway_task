<template>
    <div class="main-header with-side-menu"> <!-- class="with-side-menu" -->
        <div class="container">

            <div class="main-header-left">
                <a @click="toggleSideBar()" class="main-header-menu-icon d-lg-none" href="javascript:void(0)" id="mainNavShow"><span></span></a>
                <a class="main-logo" href="#">
                    <img :src="`${publicPath}/assets/images/logo.png`" class="header-brand-img desktop-logo" alt="logo">
                    <img :src="`${publicPath}/assets/images/icon.png`" class="header-brand-img icon-logo" alt="logo">
                    <img :src="`${publicPath}/assets/images/logo-light.png`" class="header-brand-img desktop-logo theme-logo" alt="logo">
                    <img :src="`${publicPath}/assets/images/icon-light.png`" class="header-brand-img icon-logo theme-logo" alt="logo">
                </a>
            </div>

            <div class="main-header-right">

<!--                <div class="dropdown d-md-flex">-->
<!--                    <a @click="fullScreenMode()" class="nav-link icon full-screen-link">-->
<!--                        <i class="las la-expand fullscreen-button"></i>-->
<!--                    </a>-->
<!--                </div>-->

                <LangSwitcher :show="false"/>
<!--                <div class="dropdown main-header-notification">-->
<!--                    <a class="nav-link icon" href="">-->
<!--                        <i class="las la-bell"></i>-->
<!--                        <span class="pulse bg-danger"></span>-->
<!--                    </a>-->
<!--                    <div class="dropdown-menu">-->
<!--                        <p class="main-headNav-text text-center p-3">-->
<!--                            You have 1 unread notification-->
<!--                            <span class="badge rounded-pill bg-primary ms-3 text-white">View all</span>-->
<!--                        </p>-->
<!--                        <ul class="main-notification-list">-->

<!--                            <li class="media d-flex">-->
<!--                                <div class="flex-shrink-0 main-img-user online">-->
<!--                                    <img alt="avatar" :src="`${publicPath}/assets/images/5.jpg`">-->
<!--                                </div>-->
<!--                                <div class="flex-grow-1 ms-3 media-body">-->
<!--                                    <p>Congratulate <strong>Olivia James</strong> for New template start</p>-->
<!--                                    <span>Oct 15 12:32 pm</span>-->
<!--                                </div>-->
<!--                            </li>-->

<!--                            <li class="media d-flex">-->
<!--                                <div class="flex-shrink-0 main-img-user online">-->
<!--                                    <img alt="avatar" :src="`${publicPath}/assets/images/5.jpg`">-->
<!--                                </div>-->
<!--                                <div class="flex-grow-1 ms-3 media-body">-->
<!--                                    <p>Congratulate <strong>Olivia James</strong> for New template start</p>-->
<!--                                    <span>Oct 15 12:32 pm</span>-->
<!--                                </div>-->
<!--                            </li>-->

<!--                        </ul>-->
<!--                        <div class="noti-footer text-center">-->
<!--                            <a href="" class="text-primary">View All Notifications</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="dropdown main-profile-menu">
                    <a class="main-img-user" href="">
                        <img alt="avatar" :src="`${publicPath}/assets/images/user.png`">

                    </a>
                    <div class="dropdown-menu">
                        <div class="header-navheading text-center">
                            <h6 class="main-headNav-title">{{ username }}</h6>
                            <p class="main-headNav-text">{{ roles }}</p>
                        </div>
                        <ul class="profileMenu">
                            <li class="dropdown-item">
                                <router-link  to="/edit-profile">
                                    <i class="las la-user"></i> {{ $t('pages.profile') }}
                                </router-link>
                            </li>
                            <li class="dropdown-item">
                                <a href="#" @click.prevent="logout">
                                    <i class="las la-power-off"></i> {{ $t('pages.sign_out') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LangSwitcher from "@/views/layouts/partials/LangSwitcher.vue";
import {
    mapState
} from 'pinia'
import {useAuthUserStore} from "@/store/user";
export default {
    name: 'top-bar',

    components: {
        LangSwitcher,
    },
    data() {
        return {
        }
    },
    created() {
    },
    computed: {
        ...mapState(useAuthUserStore, {
            username: state => state.user.name,
            roles: state => state.user.roles
        }),
    },
    mounted: function () {
        $('.main-header .dropdown > a').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('show');
            $(this).parent().siblings().removeClass('show');
        });
    },
    methods: {
        toggleSideBar()
        {
            if($('#mainNavShow').closest('.with-side-menu').length === 1){
                if($(window).innerWidth() <= '991.98'){
                    $('body').addClass('main-navbar-show');
                } else{
                    $('body').toggleClass('main-sidebar-hide');
                }
            }
            else{
                $('body').addClass('main-navbar-show');
            }
        },

        fullScreenMode()
        {
            $('html').addClass('fullscreenie');
            if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
                if (document.documentElement.requestFullScreen) {
                    document.documentElement.requestFullScreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullScreen) {
                    document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            } else {
                $('html').removeClass('fullscreenie');
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        },

        logout() {
            this.$store.userStore.logout()
                .then((response) => {
                    this.$router.push({
                        path: '/login'
                    });
                })
                .catch((error) => {
                    console.log(error.response.data.errors);
                });
        }
    }
}

</script>
