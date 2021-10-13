// import 'chai/register-assert';  // Using Assert style
// import 'chai/register-expect';  // Using Expect style
// import 'chai/register-should';  // Using Should style
//
// export function bootstrap(): void {
//
// }

import 'chai/register-assert'; // Using Assert style
import 'chai/register-expect'; // Using Expect style
import 'chai/register-should'; // Using Should style
import chai from 'chai';
import sinon from 'sinon';
import sinonChai from 'sinon-chai';
import btoa from 'btoa'
import {JSDOM} from 'jsdom';
import { getEnv } from './utils';

const env = getEnv()

const dom = new JSDOM(``,{
    url: env.get('APP_URL', 'http://localhost') + '/' + env.get('STREAMS_API_PREFIX', 'api'),
    contentType: "text/html",
    includeNodeLocations: true,
    storageQuota: 10000000


})

global['window'] = dom.window as any;
global.btoa = btoa;

chai.use(sinonChai);

export function bootstrap(): any {
    return { chai, sinon, env};
}

