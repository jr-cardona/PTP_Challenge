<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <span class="badge badge-light" v-if="unreadNotifications" v-text="unreadNotifications"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <span v-if="notifications.length">
                <span v-for="(notification, index) in notifications">
                    <span class="pt-1 pr-4 text-nowrap d-block"
                          :class="{ 'alert-info' : ! notification.read_at }">
                        <a class="px-2" v-text="notification.data.message"></a>
                        <a v-if="! notification.read_at"
                           href="#" @click="markAsRead(notification.id)" title="Marcar como leída">
                            <i class="fa fa-check text-success"></i>
                        </a>
                        <a class="px-2" href="#" @click="markDelete(notification, index)" title="Borrar">
                            <i class="fa fa-times text-danger"></i>
                        </a>
                    </span>
                </span>
            </span>
            <span v-else class="d-flex justify-content-center">Sin notificaciones</span>
        </div>
    </li>
</template>

<script>
    export default {
        data(){
            return {
                notifications: [],
                unreadNotifications: 0,
            }
        },
        mounted() {
            axios.get('/notificaciones').then(res => {
                this.notifications = res.data.notifications;
                this.unreadNotifications = res.data.unreadNotifications;
            })
        },
        methods: {
            markAsRead(id){
                axios.put('/notificaciones/' + id).then(res => {
                    this.notifications = res.data;
                });

                this.unreadNotifications--;
            },

            markDelete(notification, indexNotification){
                if (! notification.read_at) {
                    this.unreadNotifications--;
                }

                axios.delete('/notificaciones/' + notification.id);

                this.notifications = this.notifications.filter(function(value, index, arr){
                    return index !== indexNotification;
                });
            }
        }
    }
</script>
