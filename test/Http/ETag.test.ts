import { skip, suite, test } from '@testdeck/mocha';
import { TestCase } from '../TestCase';
import { ETag } from '@/Http/ETag';
import Axios, { AxiosInstance, AxiosRequestConfig } from 'axios';


@suite
export class ETagTest extends TestCase {

    createAxios(config?: AxiosRequestConfig): AxiosInstance {
        const axios = Axios.create(config);
        const etag  = new ETag(axios);
        return axios;
    }

    @test 'etag can be added to axios'() {
        const axios = Axios.create();
        const etag  = new ETag(axios);
        axios.etag.should.eq(etag);
    }

    @test 'etag can be enabled'() {
        const axios = this.createAxios();
        axios.etag.isEnabled().should.eq(false);
        axios.etag.enableEtag();
        axios.etag.isEnabled().should.eq(true);
    }

    @test 'etag can be disabled'() {
        const axios = this.createAxios();
        axios.etag.isEnabled().should.eq(false);
        axios.etag.enableEtag();
        axios.etag.isEnabled().should.eq(true);
        axios.etag.disableEtag();
        axios.etag.isEnabled().should.eq(false);
    }

    @skip
    @test 'etag integrates in axios requests'() {}
}
