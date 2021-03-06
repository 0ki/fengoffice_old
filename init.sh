#!/bin/bash

listurl=https://sourceforge.net/projects/opengoo/files/fengoffice/
file=fengoffice_
ext=.zip

[ ! -d ".git" ] && git init

mkdir -p $file

if [ ! -f "versions.list" ]; then
 baselist1="$(curl https://sourceforge.net/projects/opengoo/rss?path=/opengoo | grep "download</link>"|striptags | grep -Ei "/(opengoo|fengoffice)[^/]+/download$" | grep -vi upgrade | grep -vi patch | grep -F $ext | sed -Ei 's/^\s+//g;s/\s+$//g' |tac)"
 versionlist1="$(echo "$baselist1" | rev | cut -d / -f 2 |rev | sed 's/'"$(echo $ext | sed 's/\./\\./g')"'$//i')"


 baselist="$baselist1"
 versionlist="$versionlist1"

 preversionlist2=$(curl "$listurl" | grep "<span class=\"name\">" | striptags | sed -E 's/^\s+//g;s/\s+$//g' | tac)

 for v in $preversionlist2; do 
  baselist_t="$(curl -s "https://sourceforge.net/projects/opengoo/rss?path=/fengoffice/$v" | grep "download</link>"|striptags | grep -Ei "/(opengoo|fengoffice)[^/]+/download$" | grep -vi upgrade | grep -vi patch | grep -Fi $ext | sed -E 's/^\s+//g;s/\s+$//g' |tac)"
  versionlist_t="$(echo "$baselist_t" | rev | cut -d / -f 2 |rev | sed 's/'"$(echo $ext | sed 's/\./\\./g')"'$//i')"
  baselist="$baselist $baselist_t"
  versionlist="$versionlist $versionlist_t"
  echo added "$versionlist_t" to list
 done

 echo Versions: $versionlist

 versionlist=($versionlist)
 baselist=($baselist)
 for i in "${!versionlist[@]}"; do
    echo "${versionlist[i]}#${baselist[i]}"
 done > versions.list
fi

while IFS= read -r line; do
 version="$(echo $line |cut -d \# -f 1)"
 path="$(echo $line |cut -d \# -f 2-)"
 echo Downloading version $version
 mkdir -p versions/$version/
 mkdir -p versionfiles
 curl -L -C- "$path" -o versionfiles/$version$ext
 unzip -o versionfiles/$version$ext -d versions/$version/
 od="$(ls -1 versions/$version/)"
 f=$(echo "$od" | wc -l )
 if [ "$f" == "1" ]; then
  echo moving files up a step: $od
  mv -f versions/$version/$od/{.,}[^.]* versions/$version/
  rmdir versions/$version/$od
 fi
 rm -rf $file/
 mkdir -p $file
 cp -af versions/$version/{.,}[^.]* $file/
 git add $file/
 git commit -m "$version"
done < versions.list
