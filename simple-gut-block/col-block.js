/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */

wp.blocks.registerBlockType('block/border-box', {

    title: 'Colorful Message Box',
    icon: 'smiley',
    category: 'common',
    attributes: {
        content: {type: 'string'},
        color: {type: 'string'}
    },

    /* This configures how the content and color fields will work, and sets up the necessary elements */

    edit: function(props) {
        function updateContent(event) {
            props.setAttributes({content: event.target.value})
        }
        function updateColor(value) {
            props.setAttributes({color: value.hex})
        }
        return React.createElement(
            "div",
            null,
            React.createElement(
                "h3",
                null,
                "Colorful Message Box"
            ),
            React.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
            React.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
        );
    },

    save: function(props) {
        return wp.element.createElement(
            "h3",
            { style:
                {
                border: "3px solid " + props.attributes.color,
                textAlign: "center"
                }
            },
            props.attributes.content
        );
    }

})