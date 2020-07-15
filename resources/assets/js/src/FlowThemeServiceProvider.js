import Navigation from '../components/Navigation'
import Shortcuts from '../components/Shortcuts'
import Sections from '../components/Sections'
import Sidebar from '../components/Sidebar'

import {ServiceProvider} from '@anomaly/streams-platform'

export class FlowThemeServiceProvider extends ServiceProvider {
    boot(){
        Vue.component('admin-navigation', Navigation);
        Vue.component('admin-shortcuts', Shortcuts);
        Vue.component('admin-sections', Sections);
        Vue.component('admin-sidebar', Sidebar);
    }
}
