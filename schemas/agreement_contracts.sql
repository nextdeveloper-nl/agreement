-- PostgreSQL

CREATE TABLE agreement_contracts (
    id                  integer NOT NULL DEFAULT nextval('agreement_contracts_id_seq'::regclass),
    uuid                uuid DEFAULT gen_random_uuid(),
    name                text NOT NULL,
    description         text,
    object_type         text,
    object_id           integer,
    is_signed           boolean DEFAULT false,
    data                json,
    iam_user_id         integer NOT NULL,
    iam_account_id      integer NOT NULL,
    created_at          timestamp with time zone DEFAULT now(),
    updated_at          timestamp with time zone DEFAULT now(),
    deleted_at          timestamp with time zone,
    reference           text, -- Reference to the agreement template file, provided by 3rd party.
    template_reference  text, -- Reference to the agreement template file, provided by 3rd party.
    CONSTRAINT agreement_contracts_pkey PRIMARY KEY (id),
    CONSTRAINT agreement_contracts_uuid_key UNIQUE (uuid)
);
