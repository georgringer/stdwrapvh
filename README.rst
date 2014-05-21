.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

=============================================================
EXT stdwrapvh: Use stdwrap on any fluid output
=============================================================

This extension provides a ViewHelper to be able to apply any stdwrap configuration.


Requirements
=============
- TYPO3 6.0+


How to use
==================

Using this extension is simple! Just follow this steps:

- Install the extension.
- Adopt the fluid templates

.. note::

   If you don't change your templates, you will just see nothing changed. :)

Namespace declaration
---------------------

You will always need the namespace declaration: ::

  {namespace stdwrap=GeorgRinger\Stdwrapvh\ViewHelpers}


Basic Example
-------------

To demonstrate the ViewHelper, take a look at this really basic example which will just wrap the news title with "fo|bar": ::

	<stdwrap:render table="tx_news_domain_model_news" fields="title,teaser" id="{newsItem.uid}" configuration="{wrap:'fo|bar'}" mode="">
		{newsItem.title}
	</stdwrap:render>

Edit Icons
----------

A predefined configuration can be used for edit icons: ::

	<stdwrap:render table="tx_news_domain_model_news" fields="title,teaser" id="{newsItem.uid}" mode="editIcon">
		<n:link newsItem="{newsItem}" settings="{settings}">
			{newsItem.title}
		</n:link>
	</stdwrap:render>

this will show the edit icon of the frontend editing which will linke to a popup where the fields title & teaser are editable.

Edit Panel
----------

The edit panel is used to link to the whole record in a popup.::

	<stdwrap:render table="tx_news_domain_model_news" fields="title,teaser" id="{newsItem.uid}" mode="editPanel" />

Misc
=============

Author
------

Author of this extension is Georg Ringer (http://www.montagmorgen.at).


Contribution & Bug reports
------------------------------

Any contribution is highly welcomed. Please use the bugtracker of the `GitHub Project <https://github.com/georgringer/stdwrapvh/issues>`_


License
------------------

The extension is licensed under GPL 2.0, same as TYPO3 CMS.
