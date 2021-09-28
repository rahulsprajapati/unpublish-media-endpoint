Unpublish Media Endpoint
======================

![Unit tests](https://github.com/rahulsprajapati/unpublish-media-endpoint/actions/workflows/unit-test.yml/badge.svg) ![SonarCloud Coverage](https://github.com/rahulsprajapati/unpublish-media-endpoint/actions/workflows/coverage.yml/badge.svg) 

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=rahulsprajapati_unpublish-media-endpoint&metric=alert_status)](https://sonarcloud.io/dashboard?id=rahulsprajapati_unpublish-media-endpoint) [![Coverage](https://sonarcloud.io/api/project_badges/measure?project=rahulsprajapati_unpublish-media-endpoint&metric=coverage)](https://sonarcloud.io/dashboard?id=rahulsprajapati_unpublish-media-endpoint) 

This plugin will enable media endpoint in case of the post it was uploaded from ( set as post parent ) is no longer in publish status, to fix issue of not able to use it in another post REST endpoint as featured image.

Core ticket ref: https://core.trac.wordpress.org/ticket/41445

 > If media is uploaded for a post, then used as a featured image on another post, and the original parent is not accessible via the REST API (e.g. because it's in the trash, not published etc), then it cannot be embedded on the post that is accessible.


To reproduce issue:

1. Create a new post with a featured image.
2. Move the post to trash.
3. Create another post and use the image uploaded from the post moved to trash and attache it as featured image.
4. Check the response of this second post REST API with media embed enabled. ( i.e https://localhost/wp-json/wp/v2/posts/somePostID?_embed )
5. You will notice `rest_forbidden` error as per below screenshot.

![Before](./screenshots/Screenshot-1.png)

Enable this plugin and notice the response for step 4, you'll see expected media endpoint output:

![After](./screenshots/Screenshot-2.png)
