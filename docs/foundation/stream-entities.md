# Stream Entities

- [Introduction](#introduction)
	- [The Entity Pattern](#the-entity-pattern)
	- [Pattern Basics](#pattern-basics)

<a name="introduction"></a>
## Introduction

When describing various Streams in this documentation the term `Entity` refers to the specific Stream. If you create a stream of invitations the entity in this case would be an `invitation`.

<a name="the-entity-pattern"></a>
### The Entity Pattern

The entity pattern is a pattern specifying specific naming and organization of your classes for any given Streams entity. By following the `Entity Pattern` you can bypass the majority of common setup for builders and other services that use your Stream saving you time and money and helping you organize your projects in a predictable manner.

**Keep in mind you may choose to NOT use the Entity Pattern. You can still use 100% of the services available but must define some properties manually.**

<a name="pattern-basics"></a>
### Pattern Basics

The basic idea of the `Entity Pattern` is to organize your various classes for a Stream in it's own Entity namespace and use progressive naming that follows service namespaces.

The starting point for the `Entity Pattern` is the Entity's `Model`. For this example we will continue to use the `invitation` entity. Because everything is PSR standardized, we will be focusing on class names from the perspective of file organization.

#### Transforming Classes

In order to create a model within the `Entity Pattern` we will create our model like so:

	src/Invitation/InvitationModel.php

 