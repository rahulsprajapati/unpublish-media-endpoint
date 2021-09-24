Unpublish Media Endpoint
======================

This plugin will enable media endpoint in case of the post it was uploaded from ( set as post parent ) is no longger in publish status, to fix issue of not able to use it in another post REST endpoint as featured image.

core ticket ref: https://core.trac.wordpress.org/ticket/41445

 > If media is uploaded for a post, then used as a featured image on another post, and the original parent is not accessible via the REST API (e.g. because it's in the trash, not published etc), then it cannot be embedded on the post that is accessible.


