(function (blocks, element, editor, components, apiFetch) {
    var el = element.createElement;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;

    blocks.registerBlockType('gcb/client-block', {
        title: 'Client Block',
        icon: 'groups',
        category: 'common',
        attributes: {
            clients: {
                type: 'array',
                default: []
            },
            numClients: {
                type: 'number',
                default: 5
            },
            order: {
                type: 'string',
                default: 'asc'
            }
        },
        edit: function (props) {
            var attributes = props.attributes;

            function fetchClients() {
                apiFetch({ path: '/wp/v2/client' }).then(clients => {
                    const formattedClients = clients.map(client => ({
                        name: client.name,
                        lastName: client.lastName,
                        provincia: client.provincia,
                        url: client.url
                    }));
                    props.setAttributes({ clients: formattedClients });
                });
            }

            function updateNumClients(newNumClients) {
                props.setAttributes({ numClients: newNumClients });
            }

            function updateOrder(newOrder) {
                props.setAttributes({ order: newOrder });
            }

            if (attributes.clients.length === 0) {
                fetchClients();
            }

            return [
                el(InspectorControls, { key: 'controls' },
                    el(PanelBody, { title: 'Settings', initialOpen: true },
                        el(TextControl, {
                            label: 'Number of Clients',
                            type: 'number',
                            value: attributes.numClients,
                            onChange: updateNumClients
                        }),
                        el(SelectControl, {
                            label: 'Order',
                            value: attributes.order,
                            options: [
                                { label: 'Ascending', value: 'asc' },
                                { label: 'Descending', value: 'desc' }
                            ],
                            onChange: updateOrder
                        })
                    )
                ),
                el('table', { className: props.className },
                    el('thead', {},
                        el('tr', {},
                            el('th', {}, 'Name'),
                            el('th', {}, 'Last Name'),
                            el('th', {}, 'Provincia')
                        )
                    ),
                    el('tbody', {},
                        attributes.clients
                            .sort((a, b) => {
                                if (attributes.order === 'asc') {
                                    return a.lastName.localeCompare(b.lastName);
                                }
                                return b.lastName.localeCompare(a.lastName);
                            })
                            .slice(0, attributes.numClients)
                            .map(function (client, index) {
                                return el('tr', { key: index },
                                    el('td', {},
                                        el('a', { href: client.url, target: '_blank', rel: 'noopener' }, client.name)
                                    ),
                                    el('td', {},
                                        el('a', { href: client.url, target: '_blank', rel: 'noopener' }, client.lastName)
                                    ),
                                    el('td', {}, client.provincia)
                                );
                            })
                    )
                )
            ];
        },
        save: function (props) {
            var attributes = props.attributes;
            return el('table', { className: 'wp-block-gcb-client-block' },
                el('thead', {},
                    el('tr', {},
                        el('th', {}, 'Name'),
                        el('th', {}, 'Last Name'),
                        el('th', {}, 'Provincia')
                    )
                ),
                el('tbody', {},
                    attributes.clients.slice(0, attributes.numClients).map(function (client, index) {
                        return el('tr', { key: index },
                            el('td', {},
                                el('a', { href: client.url, target: '_blank', rel: 'noopener' }, client.name)
                            ),
                            el('td', {},
                                el('a', { href: client.url, target: '_blank', rel: 'noopener' }, client.lastName)
                            ),
                            el('td', {}, client.provincia)
                        );
                    })
                )
            );
        }
    });
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor, 
    window.wp.components,
    window.wp.apiFetch
));







