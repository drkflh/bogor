<label for="{{ $form['model'] }}" >{{ $label }}</label>
<div style="height:450px;max-height: 600px;display: block;">
    <b-tabs content-class="mt-3">
        <b-tab title="Source" active>
            <textarea
                style="min-height:400px;height:400px;"
                name="{{ $form['model'] }}"
                v-model="{{ $form['model'] }}"
                @if(isset($form['v_show']))
                v-show="{!! $form['v_show'] !!}"
                @endif
                @if(isset($form['placeholder']))
                placeholder="{!! $form['placeholder'] !!}"
                @endif
                @if(isset($form['class']))
                class="form-control {!! $form['class'] !!}"
                @else
                class="form-control"
                @endif
            >
            </textarea>
        </b-tab>
        <b-tab title="Preview">
            <vue-markdown
                style="min-height: 400px;"
                :source="{{ $form['model'] }}"
            ></vue-markdown>
        </b-tab>
        <b-tab title="Markdown Help">
            <pre style="font-size: 8pt;height: 40vh;max-height:600px;overflow-y: scroll;">
                # h1 Heading 8-)
<h2> h2 Heading by HTML</h2>
## h2 Heading
### h3 Heading

## Horizontal Rules

___

---

***

## Typographic replacements

Enable typographer option to see result.

(c) (C) (r) (R) (tm) (TM) (p) (P) +-

test.. test... test..... test?..... test!....

!!!!!! ???? ,,  -- ---

"Smartypants, double quotes" and 'single quotes'


## Emphasis

**This is bold text**

__This is bold text__

*This is italic text*

_This is italic text_

~~Strikethrough~~


## Blockquotes


> Blockquotes can also be nested...
>> ...by using additional greater-than signs right next to each other...
> > > ...or with spaces between arrows.


## Lists

Unordered

+ Create a list by starting a line with `+`, `-`, or `*`
+ Sub-lists are made by indenting 2 spaces:
  - Marker character change forces new list start:
    * Ac tristique libero volutpat at
    + Facilisis in pretium nisl aliquet
    - Nulla volutpat aliquam velit
+ Very easy!

Ordered

1. Lorem ipsum dolor sit amet
2. Consectetur adipiscing elit
3. Integer molestie lorem at massa


1. You can use sequential numbers...
1. ...or keep all the numbers as `1.`

Start numbering with offset:

57. foo
1. bar


## Code

Inline `code`

Indented code

    // Some comments
    line 1 of code
    line 2 of code
    line 3 of code


Block code "fences"

```
Sample text here...
```
Syntax highlighting

``` javascript
var foo = function (bar) {
  return bar++;
};

console.log(foo(5));
```

``` go
package main

import "fmt"

func main() {
	fmt.Println("Hello, world!")
}
```

## Tables

| Option | Description |
| ------ | ----------- |
| data   | path to data files to supply the data that will be passed into templates. |
| engine | engine to be used for processing templates. Handlebars is the default. |
| ext    | extension to be used for dest files. |

Right aligned columns

| Option | Description |
| ------:| -----------:|
| data   | path to data files to supply the data that will be passed into templates. |
| engine | engine to be used for processing templates. Handlebars is the default. |
| ext    | extension to be used for dest files. |

## Links

[vue-markdown](https://github.com/miaolz123/vue-markdown)

[link with title](https://github.com/miaolz123/vue-markdown "VueMarkdown")

Autoconverted link https://github.com/miaolz123/vue-markdown (enable linkify to see)


## Images

![Minion](dist/img/minion.png)

Like links, Images also have a footnote style syntax

![Alt text][id]

With a reference later in the document defining the URL location:

[id]: dist/img/minion.png  "The Dojocat"


### Emojies

> Classic markup: :wink: :cry: :laughing: :yum:
>
> Shortcuts (emoticons): :-) :-( 8-) ;)


### Subscript / Superscript

- 19^th^
- H~2~O


### \<ins>

++Inserted text++


### \<mark>

==Marked text==


### Footnotes

Footnote 1 link[^first].

Footnote 2 link[^second].

Inline footnote^[Text of inline footnote] definition.

Duplicated footnote reference[^second].

[^first]: Footnote **can have markup**

    and multiple paragraphs.

[^second]: Footnote text.


### Definition lists

Term 1

:   Definition 1
with lazy continuation.

Term 2 with *inline markup*

:   Definition 2

        { some code, part of Definition 2 }

    Third paragraph of definition 2.

_Compact style:_

Term 1
  ~ Definition 1

Term 2
  ~ Definition 2a
  ~ Definition 2b


### Abbreviations

This is HTML abbreviation example.

It converts "HTML", but keep intact partial entries like "xxxHTMLyyy" and so on.

*[HTML]: Hyper Text Markup Language
            </pre>
        </b-tab>
    </b-tabs>
</div>
