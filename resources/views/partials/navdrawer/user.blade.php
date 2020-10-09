<v-navigation-drawer
    v-model="drawer.user"
    app
    clipped
>
<v-list dense>
    <v-list-item @click="openurl('/home')">
        <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
        </v-list-item-action>
        <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
        </v-list-item-content>
    </v-list-item>
    <v-list-item @click="openurl('/archive/board')">
        <v-list-item-action>
            <v-icon>mdi-arrow-down-bold-circle</v-icon>
        </v-list-item-action>
        <v-list-item-content>
            <v-list-item-title>Board Archive</v-list-item-title>
        </v-list-item-content>
    </v-list-item>
    <v-list-item @click="openurl('/archive/committee')">
        <v-list-item-action>
            <v-icon>mdi-arrow-down-bold-circle-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
            <v-list-item-title>Committee Archive</v-list-item-title>
        </v-list-item-content>
    </v-list-item>
    <v-list-item @click="openurl('/notification')">
        <v-list-item-action>
            <v-icon>mdi-bell-ring</v-icon>
        </v-list-item-action>
        <v-list-item-content>
            <v-list-item-title>Notifications</v-list-item-title>
        </v-list-item-content>
    </v-list-item>
    {{-- <v-list-item @click="openurl('/user')">
        <v-list-item-action>
            <v-icon>mdi-account-circle</v-icon>
        </v-list-item-action>
        <v-list-item-content>
            <v-list-item-title>Users</v-list-item-title>
        </v-list-item-content>
    </v-list-item> --}}
</v-list>
</v-navigation-drawer>