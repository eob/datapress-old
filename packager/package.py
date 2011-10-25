#!/usr/bin/env python
# encoding: utf-8
"""
package.py

Packages the DataPress plugin

Created by Ted Benson on 25 Oct 2012.
"""
import os
import sys
import logging
import optparse
import shutil

def process_command_line(argv):
  """
  Return a 2-tuple: (settings object, args list).
  `argv` is a list of arguments, or `None` for ``sys.argv[1:]``.
  """
  if argv is None:
    argv = sys.argv[1:]
 
  # initialize the parser object:
  parser = optparse.OptionParser(
  formatter=optparse.TitledHelpFormatter(width=78),
  add_help_option=None)
 
  # define options here:
  parser.add_option("-i", "--inputdir", dest="indir", 
                    help="Input Directory (default: ../)", default="../")
  parser.add_option("-o", "--outputdir", dest="outdir", 
                    help="Output Directory (default = target)", default="target")
  parser.add_option("-s", "--scaffolddir", dest="scaffold", 
                    help="Scaffold Directory (default = ../plugin-scaffold)", default="../plugin-scaffold")
  parser.add_option("-b", "--blast", action="store_true", dest="blast", 
                    help="Blast away existing files in output dir?", default=False)
  parser.add_option(      # customized description; put --help last
  '-h', '--help', action='help',
  help='Show this help message and exit.')
 
  options, args = parser.parse_args(argv)
 
  # check number of arguments, verify values, etc.:
 
  return options, args

def run(settings):
  print "Settings: %s" % str(settings)
  # --------------------------------------------------------------
  # Step 1: Create the output directory. 
  # Fail if it already exists and blast option hasn't been added
  print "# Step 1: Copy scaffold to output directory"
  if os.path.exists(settings.outdir):
    if settings.blast:
      print "  - Blasting existing output directory"
      shutil.rmtree(settings.outdir)
      shutil.copytree(settings.scaffold, settings.outdir)
    else:
      print "ERROR: Output directory exists! Use --blast option to wipe it away."
      return
  else:
    print "  - Creating new output directory"
    shutil.copytree(settings.scaffold, settings.outdir)

  # --------------------------------------------------------------
  # Step 2: 
  print "# Step 2:" 
   
def main(argv=None):
  settings, args = process_command_line(argv)
  # application code here, like:
  run(settings)
  return 0        # success

if __name__ == '__main__':
  status = main()
  sys.exit(status)
