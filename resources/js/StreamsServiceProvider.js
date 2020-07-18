import {ServiceProvider} from './ServiceProvider';
import {Agent,Cookies, Storage} from './utils';


export class StreamsServiceProvider extends ServiceProvider {
    register(){
        this.app.singleton('storage', Storage)
        this.app.singleton('cookies', Cookies)
        this.app.singleton('agent', Agent)
    }
}
