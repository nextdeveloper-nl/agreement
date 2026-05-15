# NextDeveloper Agreement

This module is a part of the NextDeveloper project. It provides a way to create and manage agreements between the store owner and the customer.

## Requirements

- [NextDeveloper Iam](https://github.com/nextdeveloper-nl/iam)
- [NextDeveloper Commons](https://github.com/nextdeveloper-nl/commons)

## Installation

You can install the package via Composer:

```bash
composer require nextdeveloper/agreement
```

## Database Tables

The package includes the following tables:

- `agreement_templates`
- `agreement_contracts`
- `agreement_webhooks`

## Usage

### Storing Agreement Templates

You can store agreement templates using the following example:

```bash
curl -X POST \
  http://example.com/agreement/templates \
  -H 'Accept: application/json' \
  -H 'Content-Type: application/json' \
  -H 'Authorization: Bearer {token}' \
  -d '{
    "name": "Terms and Conditions",
    "description": "Terms and Conditions",
    "reference": "2ab1eefc-c585-4b80-9d85-ba9e5a1a45af"  // This is the reference of the template in the external system
}'
```

### Storing Agreement Contracts

You can store agreement contracts using the following example:

```bash
curl -X POST \
  http://example.com/agreement/contracts \
  -H 'Accept: application/json' \
  -H 'Content-Type: application/json' \
  -H 'Authorization: Bearer {token}' \
  -d '{
    "name": "Terms and Conditions",
    "description": "Terms and Conditions",
    "object_type": "NextDeveloper\\Partnerships\\Database\\Models\\Partnership",
    "object_id": 1,
    "template_reference": "2ab1eefc-c585-4b80-9d85-ba9e5a1a45af"
}'
```

### Storing Webhooks

You can store webhooks using the following example:

```bash
curl -X POST \
  http://example.com/agreement/webhooks \
  -H 'Accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
    "source": "inspakt",
    "data": "{\"event\": \"agreement_created\", \"agreement_id\": 1}"
}'
```

## Commercial Support
Please let us know if you need any commercial support. We dont have such a business plan but we will be happy to help you on your project and/or applying this library in your project

## Want to contribute?
You are very welcome to contribute of course. Please send us an email so that we can get in touch and talk about details;
support@plusclouds.com



---

## Our Libraries

This library is part of the **NextDeveloper / PlusClouds open-source ecosystem**. Browse all available libraries and find the right building blocks for your next project:

[https://plusclouds.com/us/solutions/libraries](https://plusclouds.com/us/solutions/libraries)

---

## Join the Community

We believe great software is built together. The PlusClouds developer community is a place where engineers share ideas, ask questions, showcase what they have built, and help shape the direction of these libraries. Whether you are integrating a single package or building an entire platform on top of our stack, you are very welcome here.

Come and join us — we would love to see what you build:

[https://plusclouds.com/us/community](https://plusclouds.com/us/community)
