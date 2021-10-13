import { StorageAdapterInterface } from '@/Storage';
import { Config, inject } from '@';
import { injectable } from 'inversify';

export interface ETagCacheValue {
    etag: string;
    value: any;
}

@injectable()
export class ETagCache {
    @inject('storage') storage: StorageAdapterInterface;
    @inject('config') config: Config;

    get manifestKey(): string {return this.config.http.etag.manifestKey;}

    public get(key: string): ETagCacheValue | undefined {
        return this.storage.get(key);
    }

    public set(key: string, etag: string, value: any) {
        this.addToUuidManifest(key);
        return this.storage.set(key, { etag, value });
    }

    public reset() {
        this.getUuidManifest().forEach(uuid => this.storage.unset(uuid));
    }

    protected getUuidManifest(): string[] {
        if ( !this.storage.has(this.manifestKey) ) {
            this.storage.set(this.manifestKey, []);
        }
        return this.storage.get(this.manifestKey, []);
    }

    protected addToUuidManifest(uuid) {
        let manifest = this.getUuidManifest();
        manifest.push(uuid);
        this.storage.set(this.manifestKey, manifest);
    }

}
