-- PostgreSQL

CREATE TABLE agreement_webhooks (
    id            integer NOT NULL DEFAULT nextval('agreement_webhooks_id_seq'::regclass),
    uuid          uuid DEFAULT gen_random_uuid(),
    source        text,
    data          json,
    is_processed  boolean DEFAULT false,
    created_at    timestamp with time zone DEFAULT now(),
    updated_at    timestamp with time zone DEFAULT now(),
    deleted_at    timestamp with time zone,
    CONSTRAINT agreement_webhooks_pkey PRIMARY KEY (id),
    CONSTRAINT agreement_webhooks_uuid_key UNIQUE (uuid)
);
