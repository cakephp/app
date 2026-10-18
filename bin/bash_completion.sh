# shellcheck shell=bash
#
# Bash completion file for CakePHP console.
# Copy this file to a file named `cake` under `/etc/bash_completion.d/`.
# For more info check https://book.cakephp.org/5/en/console-commands/completion.html#how-to-enable-bash-autocompletion-for-the-cakephp-console
#
# Keep `COMPREPLY=( $(compgen ...) )`, because mapfile is unavailable in Bash 3.2, the macOS default.
# shellcheck disable=SC2207
_cake()
{
    local cur prev opts cake
    COMPREPLY=()
    cake="${COMP_WORDS[0]}"
    cur="${COMP_WORDS[COMP_CWORD]}"
    prev="${COMP_WORDS[COMP_CWORD-1]}"

    if [[ "$cur" == -* ]] ; then
        if [[ ${COMP_CWORD} = 1 ]] ; then
            opts=$(${cake} completion options)
        elif [[ ${COMP_CWORD} = 2 ]] ; then
            opts=$(${cake} completion options "${COMP_WORDS[1]}")
        else
            opts=$(${cake} completion options "${COMP_WORDS[1]}" "${COMP_WORDS[2]}")
        fi

        COMPREPLY=( $(compgen -W "${opts}" -- "${cur}") )
        return 0
    fi

    if [[ ${COMP_CWORD} = 1 ]] ; then
        opts=$(${cake} completion commands)
        COMPREPLY=( $(compgen -W "${opts}" -- "${cur}") )
        return 0
    fi

    if [[ ${COMP_CWORD} = 2 ]] ; then
        opts=$(${cake} completion subcommands "${prev}")
        COMPREPLY=( $(compgen -W "${opts}" -- "${cur}") )
        if [[ ${#COMPREPLY[@]} -eq 0 ]] ; then
            _filedir
            return 0
        fi
        return 0
    fi

    return 0
}

complete -F _cake cake bin/cake
