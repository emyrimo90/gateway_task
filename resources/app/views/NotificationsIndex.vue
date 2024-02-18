<script>
import AuthNotificationsApi from '@api/auth-notifications.api';

export default {
    name: 'notifications',
    data() {
        return {
            notificationsList: [],
            pagination: {},
        }
    },
    created() {
        this.getNotifications();
    },
    computed: {
        unReadNotificationsCount() {
            return this.notificationsList.filter(item => item.unread);
        },
    },
    methods: {
        getNotifications(page = 1) {
            AuthNotificationsApi.list({
                page: page,
            })
                .then(response => {
                    this.notificationsList = response.data.data;
                    this.pagination = response.data.meta;
                }).catch(error => {
                console.log(error);
            });
        },
        markRead(id) {
            AuthNotificationsApi.get({
                id: id,
            })
                .then(response => {
                    this.notificationsList = response.data.data;
                    this.pagination = response.data.meta;
                }).catch(error => {
                console.log(error);
            });
        },
        markAllRead() {
            AuthNotificationsApi.readAll({})
                .then(response => {
                    this.notificationsList = response.data.data;
                }).catch(error => {
                console.log(error);
            });
        },
    }
}

</script>

<template>
    <section class="content">
        <div class="container-fluid">
            <h4 class="font-weight-bold d-flex justify-content-between align-items-center flex-wrap">
                <span>الإشعارات</span>
                <button type="button" class="btn btn-light-warning btn-sm p-0 mx-1"
                        v-if="unReadNotificationsCount.length"
                        @click="markAllRead()">
                    <span class="notify-time text-black-50">تحديد الكل كـ مقرؤه</span>
                </button>
            </h4>

            <div class="py-2">
                <ul class="notifications">
                    <li class="notify-item media bg-white my-2 rounded p-3 shadow-sm flex-wrap
                    flex-md-nowrap d-flex justify-content-between"
                        v-for="(notificationItem,index) in notificationsList">
                        <div class="d-flex align-items-start">
                            <img :src="`${publicPath}/images/notification.png`" class="notify-icon lazyload"
                                 v-if="notificationItem.unread">
                            <div class="media-body">
                                <h6 class="font-weight-semibold notify-title">{{ notificationItem.subject }}</h6>
                                <p class="notify-msg mb-1">{{ notificationItem.data }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <span class="notify-time text-black-50">2022/3/23 3:35 م</span>
                            <button type="button" class="btn btn-light-success btn-sm p-0 mx-1"
                                    v-if="notificationItem.unread"
                                    @click="markRead(notificationItem.id)">
                                <span class="notify-time text-black-50">تحديد كـ مقرؤه</span>
                            </button>
                        </div>
                    </li>

                    <li class="notify-item media bg-white my-2 rounded p-3 shadow-sm flex-wrap
                    flex-md-nowrap d-flex justify-content-between"
                        v-if="!notificationsList.length">
                        <span class="notify-time text-danger">لا توجد إشعارات</span>
                    </li>

                </ul>

            </div>
            <pagination :pagination="pagination" @paginate="getNotifications"/>

        </div>
    </section>
</template>
