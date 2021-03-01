<!--// A Vue component for turning json into hidden input elements-->
<!--// Usage:-->
<!--// <input-hidden name="users" :value="[{name: 'Sachin'}, {name: 'Pawaskar'}]"/>-->
<!--// (value can be a: string, integer, array, object)-->
<!--//-->
<!--// will render:-->
<!--// <input class="hidden" type="text" name="users[0][name]" value="Sachin">-->
<!--// <input class="hidden" type="text" name="users[1][name]" value="Pawaskar">-->
<!--//-->
<!--// Thanks to Caleb Porzio:-->
<!--// https://gist.github.com/calebporzio/371d8421ac5ea660ad7ce174c345122b-->
<!--//-->

<script>
    import _ from 'lodash'
    export default {
        functional: true,
        props: [ 'name', 'value' ],
        render(h, context) {
            function wrapInBrackets(keys) {
                return keys.length
                    ? '[' + Array.from(keys).join('][') + ']'
                    : ''
            }
            function flatInputsFromDeepJson(item, key, h) {
                if (typeof item === 'object') {
                    return _.flatMapDeep(item, (value, newKey) => {
                        return flatInputsFromDeepJson(value, key.concat(newKey), h)
                    })
                }
                return h('input', { attrs: {
                        class: 'hidden',
                        type: 'text',
                        name: context.props.name + wrapInBrackets(key),
                        value: item,
                    }})
            }
            return flatInputsFromDeepJson(context.props.value, [], h)
        },
    }
</script>