<v-navigation-drawer
    v-model="drawer.admin"
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
        <v-list-group
            :prepend-icon="option.icon"
            :value="option.baseurl == '{{ explode( '/', \Route::getCurrentRoute()->uri )[0] }}'"
            v-for="option in options"
            :key="option.name"
        >
            <template v-slot:activator>
                <v-list-item-content>
                    <v-list-item-title>@{{ option.name }}</v-list-item-title>
                </v-list-item-content>
            </template>
            <v-list-item
                v-for="(child, i) in option.children"
                :key="i"
                link
                @click="openurl(child.url)"
            >
                <v-list-item-action>
                    <v-icon v-text="child.icon"></v-icon>
                </v-list-item-action>
                <v-list-item-title v-text="child.name"></v-list-item-title>
            </v-list-item>
        </v-list-group>
    </v-list>
</v-navigation-drawer>