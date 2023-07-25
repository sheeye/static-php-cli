<?php

declare(strict_types=1);

namespace SPC\builder\unix\library;

trait gettext
{
    protected function build()
    {
        $buildroot = BUILD_ROOT_PATH;
        shell()->cd($this->source_dir)
            ->exec(
                "{$this->builder->configure_env} ./configure " .
                '--enable-static --disable-shared ' .
                '--prefix= ' .
                '--disable-acl ' .
                '--disable-c+ ' .
                '--disable-java ' .
                '--disable-csharp ' .
                '--disable-openmp ' .
                "--with-libncurses-prefix={$buildroot} " .
                "--with-libxml2-prefix={$buildroot} " .
                "--with-libiconv-prefix={$buildroot}"
            )
            ->exec('make clean')
            ->exec("make -j{$this->builder->concurrency}")
            ->exec('make install DESTDIR=' . BUILD_ROOT_PATH);
        // $this->patchPkgconfPrefix(['s.pc']);
    }
}
