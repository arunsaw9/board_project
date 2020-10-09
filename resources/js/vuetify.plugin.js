import Vue from 'vue'
// import Vuetify from 'vuetify'
import Vuetify, {
  VApp,
  VAppBar,
  VAppBarNavIcon,
  VBtn,
  VCard,
  VCardTitle,
  VCardText,
  VCardActions,
  VCol,
  VContent,
  VContainer,
  VForm,
  VIcon,
  VImg,
  VList,
  VListItem,
  VListItemAction,
  VListItemContent,
  VListItemTitle,
  VListGroup,
  VNavigationDrawer,
  VRow,
  VSpacer,
  VToolbar,
  VTextField,
  VToolbarTitle,
  VToolbarItems,
} from 'vuetify/lib'
import { Ripple } from 'vuetify/lib/directives'

Vue.use(Vuetify, {
  components: {
    VApp,
    VAppBar,
    VAppBarNavIcon,
    VBtn,
    VCard,
    VCardTitle,
    VCardText,
    VCardActions,
    VCol,
    VContent,
    VContainer,
    VForm,
    VIcon,
    VImg,
    VList,
    VListItem,
    VListItemAction,
    VListItemContent,
    VListItemTitle,
    VListGroup,
    VNavigationDrawer,
    VRow,
    VSpacer,
    VToolbar,
    VTextField,
    VToolbarTitle,
    VToolbarItems,
  },
  directives: {
    Ripple,
  },
})

// Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: 'mdi', 
  },
})