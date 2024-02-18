import i18n from "@/lang";

const {t} = i18n.global;

export default [
    {
        path: "/dashboard",
        name: "dashboard",
        component: () => import("@views/Dashboard.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.dashboard"),
        },
    },
    {
        path: "/edit-profile",
        name: "edit-profile",
        component: () => import("@views/user/EditProfile.vue"),
        meta: {
            requiresAuth: true,
            title:  t("sidebar.edit_profile"),
            requiresPermission: false
        },
    },
    {
        path: "/users",
        name: "users",
        component: () => import("@views/users/UserIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.users"),
            action: "read_user",
        },
    },
    {
        path: "/roles",
        name: "roles",
        component: () => import("@views/roles/RoleIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "read_role",
        },
    },
    {
        path: "/roles/create",
        name: "role-create",
        component: () => import("@views/roles/RoleForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "create_role",
        },
    },
    {
        path: "/roles/edit/:id?",
        name: "edit-create",
        component: () => import("@views/roles/RoleForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "update_role",
        },
    }
    ,{
        path: "/roles/show/:id?",
        name: "show-role",
        component: () => import("@views/roles/RoleView.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "read_role",
        },
    },
    {
        path: "/settings/logs",
        name: "logs",
        component: () => import("@views/settings/logs/LogIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.logs"),
            action: "read_activity_log",
            parent: "settings",
        },
    },
    {
        path: "/settings/general",
        name: "general_settings",
        component: () => import("@views/settings/general/GeneralSettings.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.general_settings"),
            action: "read_general_settings",
            parent: "settings",
        },
    },
    {
        path: "/gateway-settings",
        name: "gateway_settings",
        component: () => import("@views/payments/gateways/GatewaySettingIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.gateway_settings"),
            action:"read_gateway_setting",
            parent: "payment_transactions",
        },
    },
    {
        path: "/transactions/:id?",
        name: "transactions",
        component: () => import("@views/payments/transactions/TransactionIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.payments"),
            action:"read_transaction",
            parent: "payment_transactions",
        },
    },
    {
        path: "/users/:id",
        name: "users-show",
        component: () => import("@views/users/UserView.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.users"),
            action: "read_user",
        },
    },

];
