-- PostgreSQL

CREATE TABLE agreement_templates (
    id                   integer NOT NULL DEFAULT nextval('agreement_templates_id_seq'::regclass),
    uuid                 uuid DEFAULT gen_random_uuid(),
    name                 text NOT NULL,
    description          text NOT NULL,
    reference            text NOT NULL, -- Reference to the agreement template file, provided by 3rd party.
    created_at           timestamp with time zone DEFAULT now(),
    updated_at           timestamp with time zone DEFAULT now(),
    deleted_at           timestamp with time zone,
    fields               json, -- Fields of the agreement template. If value is true, field is required, if value is false, field is optional.
    class                text, -- Class of the agreement template.
    parameters           json, -- Parameters of the agreement template.
    slug                 text,
    iam_account_id       bigint,
    agreement_processor  text DEFAULT 'inspakt'::text,
    CONSTRAINT agreement_templates_pkey PRIMARY KEY (id),
    CONSTRAINT agreement_templates_uuid_key UNIQUE (uuid)
);
