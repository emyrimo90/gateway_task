<template>
    <div class="main-navbar side-menu main-sidebar-sticky">
        <div class="sidemenu-logo">
            <a class="main-logo" href="">
                <img :src="`${publicPath}/assets/images/logo.svg`" class="header-brand-img desktop-logo" alt="logo">
            </a>
        </div>
        <div class="container main-sidemenu">
            <div class="main-sidebar-body">
                <ul class="nav">

                    <li class="nav-label">{{ $t('sidebar.dashboard') }}</li>
                    <li :class="`nav-item ${this.$route.name == 'dashboard' ? 'active' : ''}`">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="las la-tv"></i>
                            <span class="sidemenu-label">{{ $t('sidebar.dashboard') }}</span>
                        </router-link>
                    </li>
                    <li :class="`nav-item ${this.$route.name == 'users' ? 'active' : ''}`" v-if="can('read_user')">
                        <router-link to="/users" class="nav-link">
                            <i class="las la-users"></i>
                            <span class="sidemenu-label">{{ $t('sidebar.users') }}</span>
                        </router-link>
                    </li>

                    <li :class="`nav-item ${this.$route.name == 'roles' ? 'active' : ''}`" v-if="can('read_role')">
                        <router-link to="/roles" class="nav-link">
                            <i class="las la-user-lock"></i>
                            <span class="sidemenu-label">{{ $t('sidebar.roles') }}</span>
                        </router-link>
                    </li>

                    <li :class="`nav-item ${this.$route.meta.parent == 'transactions' ? 'show  active' : ''}`"
                        v-if="can('read_transaction') || can('read_gateway_setting')">
                        <a class="nav-link subMenu with-sub" href="#">
                            <i class="fa fa-money-bill"></i>
                            <span class="sidemenu-label">{{ $t('sidebar.payment_transactions') }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item" v-if="can('read_gateway_setting')">
                                <router-link to="/gateway-settings" class="nav-sub-link">
                                    {{$t('sidebar.gateway_settings')}}
                                </router-link>
                            </li>
                        </ul>
                        <ul class="nav-sub">
                            <li class="nav-sub-item" v-if="can('read_transaction')">
                                <router-link to="/transactions" class="nav-sub-link">
                                    {{$t('sidebar.payments')}}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li :class="`nav-item ${this.$route.meta.parent == 'settings' ? 'show  active' : ''}`"
                        v-if="can('read_activity_log')">
                        <a class="nav-link subMenu with-sub" href="#">
                            <i class="las la-cog"></i>
                            <span class="sidemenu-label">{{ $t('sidebar.settings') }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item" v-if="can('read_activity_log')">
                                <router-link to="/settings/logs" class="nav-sub-link">
                                    {{$t('sidebar.logs')}}
                                </router-link>
                            </li>
                        </ul>
                        <ul class="nav-sub">
                            <li class="nav-sub-item" v-if="can('read_general_settings')">
                                <router-link to="/settings/general" class="nav-sub-link">
                                    {{$t('sidebar.general_settings')}}
                                </router-link>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name: 'side-bar',
    mounted: function () {
        $('.main-navbar .subMenu').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('show');
            $(this).parent().siblings().removeClass('show');
        });
    },
}

</script>
