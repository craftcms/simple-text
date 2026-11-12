/**
 * Simple Text’s field input: the control panel’s textarea with Behave.js editing.
 *
 * Behave.js closes brackets and quotes, deletes empty pairs, and indents new lines inside brackets
 * and continues lists when you press Enter. Indenting follows the control panel’s Markdown field,
 * so keyboard users can still leave the field with Tab:
 *
 * - Tab and Shift+Tab indent and outdent the selected lines, and only move focus when nothing is selected.
 * - Ctrl/Cmd+] and Ctrl/Cmd+[ indent and outdent the current line or the selected lines.
 */
(() => {
  const INDENT = '    ';

  /**
   * Behave.js and the indent keys cancel the key and change the value themselves, without an `input`
   * event, which the textarea needs to see the change. (Behave’s hooks miss some changes, such as
   * Backspace deleting an empty pair of brackets.) Listens after them.
   */
  function notifyHandledKey(event) {
    if (event.defaultPrevented) {
      event.currentTarget.dispatchEvent(new Event('input', {bubbles: true}));
    }
  }

  /** Indents or outdents every line touched by the selection, or the line with the caret. */
  function indentLines(textarea, outdent) {
    const {value, selectionStart: start, selectionEnd: end} = textarea;
    const from = value.lastIndexOf('\n', start - 1) + 1;
    // A selection that ends at the start of a line doesn’t include that line
    const lastLineEnd = value.indexOf(
      '\n',
      end > start && value[end - 1] === '\n' ? end - 1 : end
    );
    const to = lastLineEnd === -1 ? value.length : lastLineEnd;
    let firstLineChange = 0;
    let totalChange = 0;

    const lines = value
      .slice(from, to)
      .split('\n')
      .map((line, index) => {
        const change = outdent
          ? -(line.startsWith('\t') ? 1 : line.match(/^ {0,4}/)[0].length)
          : INDENT.length;

        if (index === 0) {
          firstLineChange = change;
        }
        totalChange += change;

        return outdent ? line.slice(-change) : INDENT + line;
      });

    if (totalChange === 0) {
      return;
    }

    textarea.setRangeText(lines.join('\n'), from, to);

    const newStart = Math.max(from, start + firstLineChange);
    textarea.setSelectionRange(
      newStart,
      start === end ? newStart : end + totalChange
    );
  }

  function onKeydown(event) {
    if (event.defaultPrevented || event.isComposing || event.altKey) {
      return;
    }

    const textarea = event.currentTarget;
    const modifier = event.metaKey || event.ctrlKey;

    if (
      modifier &&
      !event.shiftKey &&
      (event.key === ']' || event.key === '[')
    ) {
      event.preventDefault();
      event.stopPropagation();
      indentLines(textarea, event.key === '[');
    } else if (
      event.key === 'Tab' &&
      !modifier &&
      textarea.selectionStart !== textarea.selectionEnd
    ) {
      event.preventDefault();
      indentLines(textarea, event.shiftKey);
    }
  }

  let nextId = 0;

  window.Cp.booting((cp) => {
    cp.$components.register('simple-text:textarea', async () => {
      const {
        defineComponent,
        h,
        onBeforeUnmount,
        onMounted,
        onUpdated,
        ref,
        resolveComponent,
      } = await import('vue');

      return defineComponent({
        name: 'SimpleTextTextarea',
        inheritAttrs: false,
        setup(_props, {attrs}) {
          const Textarea = resolveComponent('craft:textarea');
          // Marks this instance’s <craft-textarea>, which gets the attributes core’s control doesn’t use
          const id = String(++nextId);
          const control = ref(null);
          let textarea = null;
          let behave = null;

          function detach() {
            behave?.destroy();
            textarea?.removeEventListener('keydown', onKeydown);
            textarea?.removeEventListener('keydown', notifyHandledKey);
            textarea?.removeEventListener('keypress', notifyHandledKey);
            behave = textarea = null;
          }

          // Only editable textareas get Behave.js, which edits the value without checking.
          function sync() {
            const scope = control.value?.$el?.parentNode ?? document;
            const element =
              scope.querySelector(`[data-simple-text="${id}"] textarea`) ??
              null;
            const editable = element && !element.readOnly && !element.disabled;

            if (element === textarea && Boolean(behave) === Boolean(editable)) {
              return;
            }

            detach();

            if (editable) {
              textarea = element;
              textarea.addEventListener('keydown', onKeydown);
              behave = new window.Behave({textarea, replaceTab: false});
              textarea.addEventListener('keydown', notifyHandledKey);
              textarea.addEventListener('keypress', notifyHandledKey);
            }
          }

          onMounted(sync);
          onUpdated(sync);
          onBeforeUnmount(detach);

          return () =>
            h(Textarea, {...attrs, ref: control, 'data-simple-text': id});
        },
      });
    });
  });
})();
